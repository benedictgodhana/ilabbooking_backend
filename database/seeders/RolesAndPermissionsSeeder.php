<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;


class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create roles
        $roles = [
            'Ilab Receptionist',
            'Ibiz Receptionist',
            "Director's Receptionist",
            'Admin',
            'Normal User', // New role
        ];

        foreach ($roles as $roleName) {
            Role::create(['name' => $roleName]);
        }

        // Define permissions
        $permissions = [
            'manage ilab bookings',
            'manage ibiz bookings',
            'manage director bookings',
            'manage users', // For Admin role
            'manage_rooms',
            'manage_bookings',
            'analytics_reporting',
            'system_settings',
            'manage_reservations',
            'manage_amenities',
            'help_support',
            'system_logs_audit',
            'view own profile',
            'edit own profile',
            'view bookings',
            'create booking',
            'edit own booking',
            'cancel own booking',
            
        ];

        foreach ($permissions as $permissionName) {
            Permission::create(['name' => $permissionName]);
        }

        // Create a user with roles and permissions
        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Assign roles and permissions to the user based on their role
        $user->assignRole('Admin');
        $user->givePermissionTo('manage users','manage_rooms','manage_bookings','analytics_reporting','system_settings','manage_reservations','manage_amenities','help_support','system_logs_audit'
    );

        $user = User::factory()->create([
            'name' => 'Ilab Receptionist',
            'email' => 'ilab@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Ilab Receptionist');
        $user->givePermissionTo('manage ilab bookings');

        $user = User::factory()->create([
            'name' => 'Ibiz Receptionist',
            'email' => 'ibiz@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole('Ibiz Receptionist');
        $user->givePermissionTo('manage ibiz bookings');

        $user = User::factory()->create([
            'name' => "Director's Receptionist",
            'email' => 'director@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole("Director's Receptionist");
        $user->givePermissionTo('manage director bookings');

        $user = User::factory()->create([
            'name' => "User",
            'email' => 'user@example.com',
            'password' => bcrypt('password'),
        ]);
        $user->assignRole("Normal User");
        $user->givePermissionTo('view own profile',
        'edit own profile',
        'view bookings',
        'create booking',
        'edit own booking',
        'cancel own booking',);
    }
}
