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
        $view_signs = Permission::create(['name' => 'view_signs', 'group' => 'Signs']);
        $create_signs = Permission::create(['name' => 'create_signs', 'group' => 'Signs']);
        $edit_signs = Permission::create(['name' => 'edit_signs', 'group' => 'Signs']);
        $delete_signs = Permission::create(['name' => 'delete_signs', 'group' => 'Signs']);
        // Users
        $view_users = Permission::create(['name' => 'view_users', 'group' => 'Users']);
        $create_users = Permission::create(['name' => 'create_users', 'group' => 'Users']);
        $edit_users = Permission::create(['name' => 'edit_users', 'group' => 'Users']);
        $delete_users = Permission::create(['name' => 'delete_users', 'group' => 'Users']);
        // Roles
        $view_roles = Permission::create(['name' => 'view_roles', 'group' => 'Roles']);
        $create_roles = Permission::create(['name' => 'create_roles', 'group' => 'Roles']);
        $edit_roles = Permission::create(['name' => 'edit_roles', 'group' => 'Roles']);
        $delete_roles = Permission::create(['name' => 'delete_roles', 'group' => 'Roles']);
        // Permissions
        // $view_permissions = Permission::create(['name' => 'view_permissions', 'group' => 'Permissions']);
        // $create_permissions = Permission::create(['name' => 'create_permissions', 'group' => 'Permissions']);
        // $edit_permissions = Permission::create(['name' => 'edit_permissions', 'group' => 'Permissions']);
        // $delete_permissions = Permission::create(['name' => 'delete_permissions', 'group' => 'Permissions']);

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
        $editor->givePermissionTo($view_signs);
        $editor->givePermissionTo($create_signs);
        $editor->givePermissionTo($edit_signs);
        $editor->givePermissionTo($delete_signs);
        $editor->givePermissionTo($view_users);
        $editor->givePermissionTo($create_users);
        $eu->assignRole('Editor');
        $eu->assignRole('Verified User');
    }
}
