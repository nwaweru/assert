<?php

use App\Traits\MyUuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{

    use MyUuid;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-user',
                'display_name' => 'Create User',
                'description' => 'Create a new user.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-user',
                'display_name' => 'Edit User',
                'description' => 'Edit an existing user.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-user',
                'display_name' => 'View User',
                'description' => 'View an existing user.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-users',
                'display_name' => 'View Users',
                'description' => 'View existing users.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-role',
                'display_name' => 'Create Role',
                'description' => 'Create a new role.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-role',
                'display_name' => 'Edit Role',
                'description' => 'Edit an existing role.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-role',
                'display_name' => 'View Role',
                'description' => 'View an existing role.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-roles',
                'display_name' => 'View Roles',
                'description' => 'View existing roles.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-asset-category',
                'display_name' => 'Create Asset Category',
                'description' => 'Create a new asset category.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-asset-category',
                'display_name' => 'Edit Asset Category',
                'description' => 'Edit an existing asset category.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-asset-category',
                'display_name' => 'View Asset Category',
                'description' => 'View an existing asset category.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-asset-categories',
                'display_name' => 'View Asset Categories',
                'description' => 'View existing asset-categories.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-asset',
                'display_name' => 'Create Asset',
                'description' => 'Create a new asset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-asset',
                'display_name' => 'Edit Asset',
                'description' => 'Edit an existing asset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-asset',
                'display_name' => 'View Asset',
                'description' => 'View an existing asset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-assets',
                'display_name' => 'View Assets',
                'description' => 'View existing assets.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-request',
                'display_name' => 'Create Request',
                'description' => 'Request for assignment of an asset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-request',
                'display_name' => 'Edit Asset Request',
                'description' => 'Edit a make request for assignment of an asset.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-request',
                'display_name' => 'View Asset Request',
                'description' => 'View an asset request.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'cancel-request',
                'display_name' => 'Cancel Asset Request',
                'description' => 'Cancel an asset request.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'accept-request',
                'display_name' => 'Accept Asset Request',
                'description' => 'Accept an asset request.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'reject-request',
                'display_name' => 'Reject Asset Request',
                'description' => 'Reject an asset request.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-requests',
                'display_name' => 'View Asset Requests',
                'description' => 'View asset requests.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'create-assignment',
                'display_name' => 'Create Assignment',
                'description' => 'Create a new assignment.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'edit-assignment',
                'display_name' => 'Edit Assignment',
                'description' => 'Edit an existing assignment.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-assignment',
                'display_name' => 'View Assignment',
                'description' => 'View an existing assignment.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'view-assignments',
                'display_name' => 'View Assignments',
                'description' => 'View existing assignments.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'uuid' => $this->generateUuid(),
                'name' => 'clear-assignment',
                'display_name' => 'Clear Assignment',
                'description' => 'Clear an asset assignment.',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        DB::table('permissions')->insert($permissions);
    }
}
