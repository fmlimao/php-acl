<?php

use Fmlimao\Acl;
use PHPUnit\Framework\TestCase;

require __DIR__ . '/../functions.php';

final class AclTest extends TestCase
{
    public function testCheckFullPermissions()
    {
        /*
         *
         * ROLES
         * - admin
         * - manager
         *   - manager-sales
         *   - manager-collection
         * - supervisor
         *   - supervisor-sales
         *   - supervisor-collection
         * - operator
         *   - operator-sales
         *   - operator-collections
         * - guest
         *
         *
         * RESOURCES
         * - acl
         * - registration
         * - sales
         * - collections
         *
         *
         * ROLES, RESOURCES AND PRIVILEGES
         *
         * |----------------------------|-------------------------------|
         * | admin                      | all               | all       |
         * |----------------------------|-------------------|-----------|
         * | manager                    | registration      | all       |
         * |----------------------------|-------------------|-----------|
         * | manager-sales              | sales             | all       |
         * |----------------------------|-------------------|-----------|
         * | manager-collections        | collections       | all       |
         * |----------------------------|-------------------|-----------|
         * | supervisor                 | registration      | list      |
         * |                            |                   | show      |
         * |                            |                   | create    |
         * |                            |                   | update    |
         * |----------------------------|-------------------|-----------|
         * | supervisor-sales           | sales             | list      |
         * |                            |                   | show      |
         * |                            |                   | create    |
         * |                            |                   | update    |
         * |----------------------------|-------------------|-----------|
         * | supervisor-collections     | collections       | list      |
         * |                            |                   | show      |
         * |                            |                   | create    |
         * |                            |                   | update    |
         * |----------------------------|-------------------|-----------|
         * | operator                   |                   |           |
         * |----------------------------|-------------------|-----------|
         * | operator-sales             | sales             | list      |
         * |                            |                   | show      |
         * |                            |                   | create    |
         * |----------------------------|-------------------|-----------|
         * | operator-collections       | collections       | list      |
         * |                            |                   | show      |
         * |                            |                   | create    |
         * |----------------------------|-------------------|-----------|
         * | guest                      | sales             | list      |
         * |                            |                   | show      |
         * |----------------------------|-------------------|-----------|
         *
         */

        $acl = rolesPermissions(new Fmlimao\Acl);

        $this->assertFalse($acl->isAllowed('guest', 'acl', null));
        $this->assertFalse($acl->isAllowed('guest', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('guest', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('guest', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('guest', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('guest', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('guest', 'registration', null));
        $this->assertFalse($acl->isAllowed('guest', 'registration', 'list'));
        $this->assertFalse($acl->isAllowed('guest', 'registration', 'create'));
        $this->assertFalse($acl->isAllowed('guest', 'registration', 'show'));
        $this->assertFalse($acl->isAllowed('guest', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('guest', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('guest', 'sales', null));
        $this->assertTrue($acl->isAllowed('guest', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('guest', 'sales', 'create'));
        $this->assertTrue($acl->isAllowed('guest', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('guest', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('guest', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('guest', 'collections', null));
        $this->assertTrue($acl->isAllowed('guest', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('guest', 'collections', 'create'));
        $this->assertTrue($acl->isAllowed('guest', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('guest', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('guest', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', null));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', null));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', 'list'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', 'create'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', 'show'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', null));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'collections', null));
        $this->assertTrue($acl->isAllowed('operator-collections', 'collections', 'list'));
        $this->assertTrue($acl->isAllowed('operator-collections', 'collections', 'create'));
        $this->assertTrue($acl->isAllowed('operator-collections', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('operator-collections', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', null));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', null));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', 'list'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', 'create'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', 'show'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'sales', null));
        $this->assertTrue($acl->isAllowed('operator-sales', 'sales', 'list'));
        $this->assertTrue($acl->isAllowed('operator-sales', 'sales', 'create'));
        $this->assertTrue($acl->isAllowed('operator-sales', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', null));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('operator-sales', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('operator', 'acl', null));
        $this->assertFalse($acl->isAllowed('operator', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('operator', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('operator', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('operator', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('operator', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('operator', 'registration', null));
        $this->assertFalse($acl->isAllowed('operator', 'registration', 'list'));
        $this->assertFalse($acl->isAllowed('operator', 'registration', 'create'));
        $this->assertFalse($acl->isAllowed('operator', 'registration', 'show'));
        $this->assertFalse($acl->isAllowed('operator', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('operator', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('operator', 'sales', null));
        $this->assertFalse($acl->isAllowed('operator', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('operator', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('operator', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('operator', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('operator', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('operator', 'collections', null));
        $this->assertFalse($acl->isAllowed('operator', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('operator', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('operator', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('operator', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('operator', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', null));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'registration', null));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', null));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'collections', null));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'collections', 'list'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'collections', 'create'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'collections', 'show'));
        $this->assertTrue($acl->isAllowed('supervisor-collections', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-collections', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', null));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'registration', null));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'sales', null));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'sales', 'list'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'sales', 'create'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'sales', 'show'));
        $this->assertTrue($acl->isAllowed('supervisor-sales', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', null));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor-sales', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', null));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor', 'acl', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor', 'registration', null));
        $this->assertTrue($acl->isAllowed('supervisor', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('supervisor', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('supervisor', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('supervisor', 'registration', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', null));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', null));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('supervisor', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'acl', null));
        $this->assertTrue($acl->isAllowed('manager-collections', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'acl', 'create'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'acl', 'delete'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', null));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', 'update'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', null));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('manager-collections', 'sales', 'delete'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', null));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', 'list'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', 'create'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', 'show'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', 'update'));
        $this->assertTrue($acl->isAllowed('manager-collections', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'acl', null));
        $this->assertTrue($acl->isAllowed('manager-sales', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'acl', 'create'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'acl', 'delete'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', null));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', 'update'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'registration', 'delete'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', null));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', 'list'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', 'create'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', 'show'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', 'update'));
        $this->assertTrue($acl->isAllowed('manager-sales', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', null));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('manager-sales', 'collections', 'delete'));
        $this->assertFalse($acl->isAllowed('manager', 'acl', null));
        $this->assertTrue($acl->isAllowed('manager', 'acl', 'list'));
        $this->assertFalse($acl->isAllowed('manager', 'acl', 'create'));
        $this->assertTrue($acl->isAllowed('manager', 'acl', 'show'));
        $this->assertFalse($acl->isAllowed('manager', 'acl', 'update'));
        $this->assertFalse($acl->isAllowed('manager', 'acl', 'delete'));
        $this->assertTrue($acl->isAllowed('manager', 'registration', null));
        $this->assertTrue($acl->isAllowed('manager', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('manager', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('manager', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('manager', 'registration', 'update'));
        $this->assertTrue($acl->isAllowed('manager', 'registration', 'delete'));
        $this->assertFalse($acl->isAllowed('manager', 'sales', null));
        $this->assertFalse($acl->isAllowed('manager', 'sales', 'list'));
        $this->assertFalse($acl->isAllowed('manager', 'sales', 'create'));
        $this->assertFalse($acl->isAllowed('manager', 'sales', 'show'));
        $this->assertFalse($acl->isAllowed('manager', 'sales', 'update'));
        $this->assertFalse($acl->isAllowed('manager', 'sales', 'delete'));
        $this->assertFalse($acl->isAllowed('manager', 'collections', null));
        $this->assertFalse($acl->isAllowed('manager', 'collections', 'list'));
        $this->assertFalse($acl->isAllowed('manager', 'collections', 'create'));
        $this->assertFalse($acl->isAllowed('manager', 'collections', 'show'));
        $this->assertFalse($acl->isAllowed('manager', 'collections', 'update'));
        $this->assertFalse($acl->isAllowed('manager', 'collections', 'delete'));
        $this->assertTrue($acl->isAllowed('admin', 'acl', null));
        $this->assertTrue($acl->isAllowed('admin', 'acl', 'list'));
        $this->assertTrue($acl->isAllowed('admin', 'acl', 'create'));
        $this->assertTrue($acl->isAllowed('admin', 'acl', 'show'));
        $this->assertTrue($acl->isAllowed('admin', 'acl', 'update'));
        $this->assertTrue($acl->isAllowed('admin', 'acl', 'delete'));
        $this->assertTrue($acl->isAllowed('admin', 'registration', null));
        $this->assertTrue($acl->isAllowed('admin', 'registration', 'list'));
        $this->assertTrue($acl->isAllowed('admin', 'registration', 'create'));
        $this->assertTrue($acl->isAllowed('admin', 'registration', 'show'));
        $this->assertTrue($acl->isAllowed('admin', 'registration', 'update'));
        $this->assertTrue($acl->isAllowed('admin', 'registration', 'delete'));
        $this->assertTrue($acl->isAllowed('admin', 'sales', null));
        $this->assertTrue($acl->isAllowed('admin', 'sales', 'list'));
        $this->assertTrue($acl->isAllowed('admin', 'sales', 'create'));
        $this->assertTrue($acl->isAllowed('admin', 'sales', 'show'));
        $this->assertTrue($acl->isAllowed('admin', 'sales', 'update'));
        $this->assertTrue($acl->isAllowed('admin', 'sales', 'delete'));
        $this->assertTrue($acl->isAllowed('admin', 'collections', null));
        $this->assertTrue($acl->isAllowed('admin', 'collections', 'list'));
        $this->assertTrue($acl->isAllowed('admin', 'collections', 'create'));
        $this->assertTrue($acl->isAllowed('admin', 'collections', 'show'));
        $this->assertTrue($acl->isAllowed('admin', 'collections', 'update'));
        $this->assertTrue($acl->isAllowed('admin', 'collections', 'delete'));
    }
}