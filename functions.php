<?php

function showAllowedLabel(\Fmlimao\Acl $acl, $role, $resource, $privilege)
{
    $isAllowed = $acl->isAllowed($role, $resource, $privilege == 'all' ? null : $privilege);
    $class = $isAllowed ? 'label-success' : 'label-danger';
    $text = $isAllowed ? 'True' : 'False';

    return '<span class="label ' . $class . '">' . $text . '</span>';
}

function rolesPermissions(\Fmlimao\Acl $acl)
{
    $acl->addRole('admin');
    $acl->addRole('manager');
    $acl->addRole('manager-sales', 'manager');
    $acl->addRole('manager-collections', 'manager');
    $acl->addRole('supervisor');
    $acl->addRole('supervisor-sales', 'supervisor');
    $acl->addRole('supervisor-collections', 'supervisor');
    $acl->addRole('operator');
    $acl->addRole('operator-sales', 'operator');
    $acl->addRole('operator-collections', 'operator');
    $acl->addRole('guest');

    $acl->allow('guest', ['sales', 'collections'], ['list', 'show']);
    $acl->allow('operator-collections', 'collections', ['list', 'show', 'create']);
    $acl->allow('operator-sales', 'sales', ['list', 'show', 'create']);
    $acl->allow('supervisor-collections', 'collections', ['list', 'show', 'create', 'update']);
    $acl->allow('supervisor-sales', 'sales', ['list', 'show', 'create', 'update']);
    $acl->allow('supervisor', 'registration', ['list', 'show', 'create', 'update']);
    $acl->allow('manager-collections', 'collections');
    $acl->allow('manager-sales', 'sales');
    $acl->allow('manager', 'acl', ['list', 'show']);
    $acl->allow('manager', 'registration');
    $acl->allow('admin');

    return $acl;
}
