<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/functions.php';

$acl = rolesPermissions(new Fmlimao\Acl);

$allRoles = [
    'guest',
    'operator-collections',
    'operator-sales',
    'operator',
    'supervisor-collections',
    'supervisor-sales',
    'supervisor',
    'manager-collections',
    'manager-sales',
    'manager',
    'admin',
];

$allResources = [
    'acl',
    'registration',
    'sales',
    'collections',
];

$allPrivileges = [
    'all',
    'list',
    'create',
    'show',
    'update',
    'delete',
];

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div class="container">
    <h3 class="page-header">Tests</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th rowspan="2">Roles</th>
            <th rowspan="2">Resources</th>
            <th class="text-center" colspan="<?php echo count($allPrivileges); ?>">Privileges</th>
        </tr>
        <tr>
            <?php foreach ($allPrivileges as $privilege) : ?>
                <th class="text-center"><?php echo $privilege; ?></th>
            <?php endforeach; ?>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($allRoles as $role) : ?>
            <tr>
                <td rowspan="<?php echo count($allResources); ?>"><?php echo $role; ?></td>
                <td><?php echo $allResources[0]; ?></td>
                <?php foreach ($allPrivileges as $privilege) : ?>
                    <td class="text-center"><?php echo showAllowedLabel($acl, $role, $allResources[0], $privilege); ?></td>
                <?php endforeach; ?>
            </tr>
            <?php foreach ($allResources as $k => $resource) : if (!$k) continue; ?>
                <tr>
                    <td><?php echo $resource; ?></td>
                    <?php foreach ($allPrivileges as $privilege) : ?>
                        <td class="text-center"><?php echo showAllowedLabel($acl, $role, $resource, $privilege); ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
