<?php

use App\Models\Role;
use App\Models\User;
use App\Traits\MyUuid;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    use MyUuid;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->_createDeveloperAccount();
        $this->_createUserAccount();

        factory(App\Models\User::class, 5)->create();
    }

    /**
     * Create a developer account.
     *
     * @return void
     */
    private function _createDeveloperAccount()
    {
        $user = new User;
        $user->uuid = $this->generateUuid();
        $user->username = 'nwaweru';
        $user->first_name = 'Ndirangu';
        $user->last_name = 'Waweru';
        $user->email = 'ndiranguwaweru@gmail.com';
        $user->password = bcrypt('password');
        $user->api_token = str_random(60);
        $user->verified = true;
        $user->save();

        $newUser = User::find($user->id);
        $role = Role::where('name', 'developer')->first();
        $newUser->attachRole($role->id);
    }

    /**
     * Create a user account.
     *
     * @return void
     */
    private function _createUserAccount()
    {
        $user = new User;
        $user->uuid = $this->generateUuid();
        $user->username = 'user_nwaweru';
        $user->first_name = 'Ndirangu';
        $user->last_name = 'Waweru';
        $user->email = 'nwaweru@example.com';
        $user->password = bcrypt('password');
        $user->api_token = str_random(60);
        $user->verified = true;
        $user->save();

        $newUser = User::find($user->id);
        $role = Role::where('name', 'user')->first();
        $newUser->attachRole($role->id);
    }
}
