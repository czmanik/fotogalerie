<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'manage_admins']);
        Permission::create(['name' => 'backup_database']);

        // create roles and assign existing permissions
        $adminRole = Role::create(['name' => 'Admin']);
        $adminRole->givePermissionTo('backup_database');

        $superAdminRole = Role::create(['name' => 'Super Admin']);
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign super admin role to user #1
        $user = User::find(1);
        if ($user) {
            $user->assignRole('Super Admin');
        } else {
            // If user #1 doesn't exist, create a fallback user or log info
            // For now, let's create one if it doesn't exist for testing purposes
            // Or assume the user handles creation. Let's just create one if empty to be safe
             $user = User::factory()->create([
                 'id' => 1,
                 'name' => 'Super Admin',
                 'email' => 'admin@example.com',
                 'password' => bcrypt('password'),
             ]);
             $user->assignRole('Super Admin');
        }
    }
}
