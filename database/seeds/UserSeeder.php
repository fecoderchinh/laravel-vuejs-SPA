<?php

namespace Database\Seeders;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permission = Permission::whereIn('slug', [
            'create-tasks',
            'edit-users',
            'post-comments'
        ])->get();
        $company_permission = Permission::whereIn('slug', [
            'create-tasks',
            'post-comments'
        ])->get();
        $supplier_permission = Permission::where('slug', 'post-comments')->first();

        $admin_role = new Role();
        $admin_role->slug = 'admin';
        $admin_role->name = 'Admin';
        $admin_role->save();
        $admin_role->permissions()->sync($admin_permission);

        //RoleTableSeeder.php
        $company_role = new Role();
        $company_role->slug = 'company';
        $company_role->name = 'Company';
        $company_role->save();
        $company_role->permissions()->sync($company_permission);

        $supplier_role = new Role();
        $supplier_role->slug = 'supplier';
        $supplier_role->name = 'Supplier';
        $supplier_role->save();
        $supplier_role->permissions()->attach($supplier_permission);

        $admin_role = Role::where('slug','admin')->first();
        $company_role = Role::where('slug','company')->first();
        $supplier_role = Role::where('slug', 'supplier')->first();

        $createTasks = new Permission();
        $createTasks->slug = 'create-tasks';
        $createTasks->name = 'Create Tasks';
        $createTasks->save();
        $createTasks->roles()->attach($company_role);

        $editUsers = new Permission();
        $editUsers->slug = 'edit-users';
        $editUsers->name = 'Edit Users';
        $editUsers->save();
        $editUsers->roles()->attach($admin_role);

        $postComments = new Permission();
        $postComments->slug = 'post-comments';
        $postComments->name = 'Post Comments';
        $postComments->save();
        $postComments->roles()->attach($supplier_role);

        $admin_role_new = Role::where('slug','admin')->first();
        $company_role_new = Role::where('slug','company')->first();
        $supplier_role_new = Role::where('slug', 'supplier')->first();

        $admin_permission_new = Permission::whereIn('slug', [
            'create-tasks',
            'edit-users',
            'post-comments'
        ])->get();
        $company_permission_new = Permission::whereIn('slug', [
            'create-tasks',
            'post-comments'
        ])->get();
        $supplier_permission_new = Permission::where('slug', 'post-comments')->first();

        $admin = new User();
        $admin->name = 'Admin';
        $admin->email = 'admin@admin.com';
        $admin->password = bcrypt('789512364');
        $admin->save();
        $admin->roles()->attach($admin_role_new);
        $admin->permissions()->sync($admin_permission_new);

        $company = new User();
        $company->name = 'John Doe';
        $company->email = 'john@domain.com';
        $company->password = bcrypt('secret');
        $company->save();
        $company->roles()->attach($company_role_new);
        $company->permissions()->sync($company_permission_new);

        $supplier = new User();
        $supplier->name = 'Tiffany Orlanda';
        $supplier->email = 'tiff@domain.com';
        $supplier->password = bcrypt('secret');
        $supplier->save();
        $supplier->roles()->attach($supplier_role_new);
        $supplier->permissions()->attach($supplier_permission_new);
    }
}
