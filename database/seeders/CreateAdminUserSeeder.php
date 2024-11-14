<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Admin LAB STIKes', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Admin Lab']);

        
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);

        $role = Role::create(['name' => 'Mahasiswa']);
    }
}