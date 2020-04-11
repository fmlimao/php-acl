<?php

namespace Fmlimao;

class Acl
{
    private $rules = [
        'allRoles' => [
            'allResources' => [
                'allPrivileges' => [
                    'value' => false,
                ],

                'byPrivilege' => [],
            ],

            'byResource' => [],
        ],

        'byRole' => [],
    ];

    private function createNode($role = null, $resource = null)
    {
        if (!is_null($role)) {
            if (!isset($this->rules['byRole'][$role])) {
                $this->rules['byRole'][$role] = [
                    'allResources' => [
                        'allPrivileges' => [
                            'value' => false,
                        ],

                        'byPrivilege' => [],
                    ],

                    'byResource' => [],
                ];
            }

            if (!is_null($resource) && !isset($this->rules['byRole'][$role]['byResource'][$resource])) {
                $this->rules['byRole'][$role]['byResource'][$resource] = [
                    'allPrivileges' => [
                        'value' => false,
                    ],

                    'byPrivilege' => [],
                ];
            }
        } else if (!is_null($resource)) {
            if (!isset($this->rules['allRoles']['byResource'][$resource])) {
                $this->rules['allRoles']['byResource'][$resource] = [
                    'allPrivileges' => [
                        'value' => false,
                    ],

                    'byPrivilege' => [],
                ];
            }
        }
    }

    private function deleteNode($role = null, $resource = null, $privilege = null)
    {
        if (is_null($role)) {
            if (is_null($resource)) {
                if (!is_null($privilege)) {
                    unset($this->rules['allRoles']['allResources']['byPrivilege'][$privilege]);
                }
            } else {
                if (!is_null($privilege)) {
                    unset($this->rules['allRoles']['byResource'][$resource]['byPrivilege'][$privilege]);
                }
            }
        } else {
            if (is_null($resource)) {
                if (!is_null($privilege)) {
                    unset($this->rules['byRole'][$role]['allResources']['byPrivilege'][$privilege]);
                }
            } else {
                if (!is_null($privilege)) {
                    unset($this->rules['byRole'][$role]['byResource'][$resource]['byPrivilege'][$privilege]);
                }
            }
        }
    }

    private function setValue($role, $resource, $privilege, $value)
    {
        if (is_null($role)) {
            if (is_null($resource)) {
                if (is_null($privilege)) {
                    $this->rules['allRoles']['allResources']['allPrivileges'] = [
                        'value' => $value,
                    ];
                } else {
                    $this->rules['allRoles']['allResources']['byPrivilege'][$privilege] = [
                        'value' => $value,
                    ];
                }
            } else {
                if (is_null($privilege)) {
                    $this->rules['allRoles']['byResource'][$resource]['allPrivileges'] = [
                        'value' => $value,
                    ];
                } else {
                    $this->rules['allRoles']['byResource'][$resource]['byPrivilege'][$privilege] = [
                        'value' => $value,
                    ];
                }
            }
        } else {
            if (is_null($resource)) {
                if (is_null($privilege)) {
                    $this->rules['byRole'][$role]['allResources']['allPrivileges'] = [
                        'value' => $value,
                    ];
                } else {
                    $this->rules['byRole'][$role]['allResources']['byPrivilege'][$privilege] = [
                        'value' => $value,
                    ];
                }
            } else {
                if (is_null($privilege)) {
                    $this->rules['byRole'][$role]['byResource'][$resource]['allPrivileges'] = [
                        'value' => $value,
                    ];
                } else {
                    $this->rules['byRole'][$role]['byResource'][$resource]['byPrivilege'][$privilege] = [
                        'value' => $value,
                    ];
                }
            }
        }
    }

    public function allow($role = null, $resource = null, $privilege = null)
    {
        if (is_array($role)) {
            foreach ($role as $r) $this->allow($r, $resource, $privilege);
            return;
        }

        if (is_array($resource)) {
            foreach ($resource as $r) $this->allow($role, $r, $privilege);
            return;
        }

        if (is_array($privilege)) {
            foreach ($privilege as $r) $this->allow($role, $resource, $r);
            return;
        }

        $this->createNode($role, $resource);
        $this->setValue($role, $resource, $privilege, true);
    }

    public function deny($role = null, $resource = null, $privilege = null)
    {
        if (is_array($role)) {
            foreach ($role as $r) $this->deny($r, $resource, $privilege);
            return;
        }

        if (is_array($resource)) {
            foreach ($resource as $r) $this->deny($role, $r, $privilege);
            return;
        }

        if (is_array($privilege)) {
            foreach ($privilege as $r) $this->deny($role, $resource, $r);
            return;
        }

        $this->setValue($role, $resource, $privilege, false);
        $this->deleteNode($role, $resource, $privilege);
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
                    $_role = (is_null($role) || !isset($this->rules['byRole'][$role])) ? $this->rules['allRoles'] : $this->rules['byRole'][$role];
                    $_resource = (is_null($resource) || !isset($_role['byResource'][$resource])) ? $_role['allResources'] : $_role['byResource'][$resource];
                    $_privilege = (is_null($privilege) || !isset($_resource['byPrivilege'][$privilege])) ? $_resource['allPrivileges'] : $_resource['byPrivilege'][$privilege];

                    return $_privilege['value'];
                }
            }
        }
    }
}
