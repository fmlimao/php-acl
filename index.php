<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

$acl = new Fmlimao\Acl;

$acl->allow(null, ['products', 'categories'], 'list');
$acl->allow('client', ['products', 'categories'], ['list', 'create', 'edit']);
$acl->allow('client', 'orders', null);
$acl->allow('admin');

function showAllowedLabel($isAllowed) {
    $class = $isAllowed ? 'label-success' : 'label-danger';
    $text = $isAllowed ? 'True' : 'False';
    return '<span class="label ' . $class . '">' . $text . '</span>';
}

?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<div class="container">
    <h3 class="page-header">Tests</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Roles</th>
            <th>Resources</th>
            <th>Privileges</th>
            <th class="text-center">Allowed?</th>
        </tr>
        </thead>

        <tbody>
        <tr>
            <td>All</td>
            <td>Products</td>
            <td>List</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed(null, 'products', 'list')); ?></td>
        </tr>
        <tr>
            <td>All</td>
            <td>Products</td>
            <td>Create</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed(null, 'products', 'create')); ?></td>
        </tr>
        <tr>
            <td>Client</td>
            <td>Products</td>
            <td>Create</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed('client', 'products', 'create')); ?></td>
        </tr>
        <tr>
            <td>Client</td>
            <td>Categories OR Payments</td>
            <td>Edit</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed('client', ['categories', 'payments'], 'edit')); ?></td>
        </tr>
        <tr>
            <td>Client</td>
            <td>Categories</td>
            <td>Delete</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed('client', 'categories', 'delete')); ?></td>
        </tr>
        <tr>
            <td>Client</td>
            <td>Orders</td>
            <td>All</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed('client', 'orders')); ?></td>
        </tr>
        <tr>
            <td>Admin</td>
            <td>All</td>
            <td>All</td>
            <td class="text-center"><?php echo showAllowedLabel($acl->isAllowed('admin')); ?></td>
        </tr>
        </tbody>
    </table>
</div>
