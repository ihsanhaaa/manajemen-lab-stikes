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

        $laboran = User::create([
            'name' => 'Admin LAB STIKes', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Admin Lab']);

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $laboran->assignRole([$role->id]);

        $keuangan = User::create([
            'name' => 'Keuangan STIKes Sambas', 
            'email' => 'adminkeuangan@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Admin Keuangan']);

        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $keuangan->assignRole([$role->id]);
        

        // ketua stikes
        $ketua = User::create([
            'name' => 'Ketua STIKes', 
            'email' => 'ketuastikes@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Ketua STIKes']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $ketua->assignRole([$role->id]);

        // ketua stikes
        $akademik = User::create([
            'name' => 'Administrasi STIKes Sambas', 
            'email' => 'administrasi@gmail.com',
            'password' => bcrypt('1234567890')
        ]);

        $role = Role::create(['name' => 'Administrasi']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $akademik->assignRole([$role->id]);


        // mahasiswa
        $role = Role::create(['name' => 'Mahasiswa']);
    }
}