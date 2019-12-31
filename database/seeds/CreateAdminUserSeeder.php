<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $user = \App\User::create([
            'name' => 'Hossein Haghparast',
            'email' => 'admin@eplus.com',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::where('name','super-admin')->first();
        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role]);
    }

}
