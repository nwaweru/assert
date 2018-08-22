<?php

use App\Models\Role;
use App\Traits\MyUuid;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    use MyUuid;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_createDeveloperRole();
        $this->_createUserRole();
    }

    /**
     * Create a developer role.
     *
     * @return void
     */
    private function _createDeveloperRole()
    {
        $role = new Role;
        $role->uuid = $this->generateUuid();
        $role->name = 'developer';
        $role->display_name = 'Developer';
        $role->description = 'Developer';
        $role->save();

        $permissions = Permission::pluck('id');
        $role->attachPermissions($permissions);
    }

    /**
     * Create a user role.
     *
     * @return void
     */
    private function _createUserRole()
    {
        $role = new Role;
        $role->uuid = $this->generateUuid();
        $role->name = 'user';
        $role->display_name = 'User';
        $role->description = 'Basic User';
        $role->save();

        $permissions = Permission::where('name', 'create-request')
            ->orWhere('name', 'edit-request')
            ->orWhere('name', 'view-request')
            ->orWhere('name', 'cancel-request')
            ->orWhere('name', 'view-requests')
            ->pluck('id')
            ->toArray();

        $role->attachPermission($permissions);
    }
}
