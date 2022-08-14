<?php

use Illuminate\Database\Seeder;

use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run() {
        // $this->call(UserSeeder::class);
        
        // Create Permissions
        // Signs
        $create_signs = Permission::create(['name' => 'create_signs']);
        $view_signs = Permission::create(['name' => 'view_signs']);
        $edit_signs = Permission::create(['name' => 'edit_signs']);
        $delete_signs = Permission::create(['name' => 'delete_signs']);
        // Users
        $create_users = Permission::create(['name' => 'create_users']);
        $view_users = Permission::create(['name' => 'view_users']);
        $edit_users = Permission::create(['name' => 'edit_users']);
        $delete_users = Permission::create(['name' => 'delete_users']);
        // Roles
        $create_roles = Permission::create(['name' => 'create_roles']);
        $view_roles = Permission::create(['name' => 'view_roles']);
        $edit_roles = Permission::create(['name' => 'edit_roles']);
        $delete_roles = Permission::create(['name' => 'delete_roles']);
        // Permissions
        $create_permissions = Permission::create(['name' => 'create_permissions']);
        $view_permissions = Permission::create(['name' => 'view_permissions']);
        $edit_permissions = Permission::create(['name' => 'edit_permissions']);
        $delete_permissions = Permission::create(['name' => 'delete_permissions']);

        // Super User
        $su = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password')
        ]);
        Role::create(['name' => 'Super-Admin']);
        $su->assignRole('Super-Admin');
        
        // Verified User
        $vu = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => bcrypt('password')
        ]);
        $verified_user = Role::create(['name' => 'Verified User']);
        $verified_user->givePermissionTo($view_signs);
        $vu->assignRole('Verified User');

        // Default Editor Permissions
        $eu = User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => bcrypt('password')
        ]);
        $editor = Role::create(['name' => 'Editor']);
        $editor->givePermissionTo($create_signs);
        $editor->givePermissionTo($view_signs);
        $editor->givePermissionTo($edit_signs);
        $editor->givePermissionTo($delete_signs);
        $editor->givePermissionTo($create_users);
        $editor->givePermissionTo($view_users);
        $eu->assignRole('Editor');

    }
}
