<?php

namespace Fmlimao;

class Acl
{
    private $roles = [];

    private $rules = [
        'allRoles' => [
            'type' => 'all',

            'allResources' => [
                'type' => 'all',

                'allPrivileges' => [
                    'type' => 'all',
                    'value' => null,
                ],

                'byPrivilege' => [],
            ],

            'byResource' => [],
        ],

        'byRole' => [],
    ];

    public function addRole($role, $parent = null)
    {
        if (is_string($role)) {
            if (!isset($this->roles[$role])) {
                $this->roles[$role] = [
                    'name' => $role,
                    'parents' => [],
                    'children' => [],
                ];
            }

            if (!is_null($parent)) {
                if (is_array($parent)) {
                    foreach ($parent as $p) {
                        $this->addRole($role, $p);
                    }
                    return;
                } elseif (is_string($parent)) {
                    $this->addRole($parent);

                    if (!in_array($parent, $this->roles[$role]['parents'])) {
                        $this->roles[$role]['parents'][] = $parent;
                    }

                    if (!in_array($role, $this->roles[$parent]['children'])) {
                        $this->roles[$parent]['children'][] = $role;
                    }
                }
            }
        }
    }

    private function createNode($role = null, $resource = null)
    {
        if (!is_null($role)) {
            if (!isset($this->rules['byRole'][$role])) {
                $this->rules['byRole'][$role] = [
                    'type' => 'role',
                    'name' => $role,

                    'allResources' => [
                        'type' => 'all',

                        'allPrivileges' => [
                            'type' => 'all',
                            'value' => null,
                        ],

                        'byPrivilege' => [],
                    ],

                    'byResource' => [],
                ];
            }

            if (!is_null($resource) && !isset($this->rules['byRole'][$role]['byResource'][$resource])) {
                $this->rules['byRole'][$role]['byResource'][$resource] = [
                    'type' => 'resource',
                    'name' => $resource,

                    'allPrivileges' => [
                        'type' => 'all',
                        'value' => null,
                    ],

                    'byPrivilege' => [],
                ];
            }
        } elseif (!is_null($resource)) {
            if (!isset($this->rules['allRoles']['byResource'][$resource])) {
                $this->rules['allRoles']['byResource'][$resource] = [
                    'type' => 'resource',
                    'name' => $resource,

                    'allPrivileges' => [
                        'type' => 'all',
                        'value' => null,
                    ],

                    'byPrivilege' => [],
                ];
            }
        }
    }

    private function setValue($role, $resource, $privilege, $value)
    {
        if (is_null($role)) {
            if (is_null($resource)) {
                if (is_null($privilege)) {
                    $this->rules['allRoles']['allResources']['allPrivileges'] = [
                        'type' => 'all',
                        'value' => $value,
                    ];
                } else {
                    $this->rules['allRoles']['allResources']['byPrivilege'][$privilege] = [
                        'type' => 'privilege',
                        'name' => $privilege,
                        'value' => $value,
                    ];
                }
            } else {
                if (is_null($privilege)) {
                    $this->rules['allRoles']['byResource'][$resource]['allPrivileges'] = [
                        'type' => 'all',
                        'value' => $value,
                    ];
                } else {
                    $this->rules['allRoles']['byResource'][$resource]['byPrivilege'][$privilege] = [
                        'type' => 'privilege',
                        'name' => $privilege,
                        'value' => $value,
                    ];
                }
            }
        } else {
            if (is_null($resource)) {
                if (is_null($privilege)) {
                    $this->rules['byRole'][$role]['allResources']['allPrivileges'] = [
                        'type' => 'all',
                        'value' => $value,
                    ];
                } else {
                    $this->rules['byRole'][$role]['allResources']['byPrivilege'][$privilege] = [
                        'type' => 'privilege',
                        'name' => $privilege,
                        'value' => $value,
                    ];
                }
            } else {
                if (is_null($privilege)) {
                    $this->rules['byRole'][$role]['byResource'][$resource]['allPrivileges'] = [
                        'type' => 'all',
                        'value' => $value,
                    ];
                } else {
                    $this->rules['byRole'][$role]['byResource'][$resource]['byPrivilege'][$privilege] = [
                        'type' => 'privilege',
                        'name' => $privilege,
                        'value' => $value,
                    ];
                }
            }
        }
    }

    public function allow($role = null, $resource = null, $privilege = null)
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                $this->allow($r, $resource, $privilege);
            }
            return;
        }

        if (is_array($resource)) {
            foreach ($resource as $r) {
                $this->allow($role, $r, $privilege);
            }
            return;
        }

        if (is_array($privilege)) {
            foreach ($privilege as $r) {
                $this->allow($role, $resource, $r);
            }
            return;
        }

        $this->createNode($role, $resource);
        $this->setValue($role, $resource, $privilege, 1);
    }

    public function deny($role = null, $resource = null, $privilege = null)
    {
        if (is_array($role)) {
            foreach ($role as $r) {
                $this->deny($r, $resource, $privilege);
            }
            return;
        }

        if (is_array($resource)) {
            foreach ($resource as $r) {
                $this->deny($role, $r, $privilege);
            }
            return;
        }

        if (is_array($privilege)) {
            foreach ($privilege as $r) {
                $this->deny($role, $resource, $r);
            }
            return;
        }

        $this->createNode($role, $resource);
        $this->setValue($role, $resource, $privilege, 0);
    }

    public function isAllowed($role = null, $resource = null, $privilege = null)
    {
        if (is_array($role)) {
            $isAllowedRole = [];
            foreach ($role as $a) {
                $isAllowedRole[] = $this->isAllowed($a, $resource, $privilege);
            }
            return !!count(array_filter($isAllowedRole));
        } else {
            if (is_array($resource)) {
                $isAllowedResource = [];
                foreach ($resource as $a) {
                    $isAllowedResource[] = $this->isAllowed($role, $a, $privilege);
                }
                return !!count(array_filter($isAllowedResource));
            } else {
                if (is_array($privilege)) {
                    $isAllowedPrivilege = [];
                    foreach ($privilege as $a) {
                        $isAllowedPrivilege[] = $this->isAllowed($role, $resource, $a);
                    }
                    return !!count(array_filter($isAllowedPrivilege));
                } else {
                    $value = null;

                    $checkOrder = [
                        ['byRole', $role, 'byResource', $resource, 'byPrivilege', $privilege],
                        ['byRole', $role, 'byResource', $resource, 'allPrivileges'],
                        ['byRole', $role, 'allResources', 'byPrivilege', $privilege],
                        ['byRole', $role, 'allResources', 'allPrivileges'],
                        ['allRoles', 'byResource', $resource, 'byPrivilege', $privilege],
                        ['allRoles', 'byResource', $resource, 'allPrivileges'],
                        ['allRoles', 'allResources', 'byPrivilege', $privilege],
                        ['allRoles', 'allResources', 'allPrivileges'],
                    ];

                    $value = null;

                    foreach ($checkOrder as $o) {
                        $obj = $this->rules;

                        $ok = true;
                        foreach ($o as $k) {
                            if (!isset($obj[$k])) {
                                $ok = false;
                                break;
                            }

                            $obj = $obj[$k];
                        }

                        if (!$ok) {
                            continue;
                        }

                        if (!is_null($obj['value'])) {
                            $value = $obj['value'];
                            break;
                        }
                    }

                    if (!is_null($value)) {
                        return !!$value;
                    }

                    if (isset($this->roles[$role])) {
                        $parents = $this->roles[$role]['parents'];
                        foreach ($parents as $parent) {
                            $value = $this->isAllowed($parent, $resource, $privilege);
                        }
                    }

                    return !!$value;
                }
            }
        }
    }
}
