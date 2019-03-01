<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Permission::create(['name' => 'Settings']);
    Permission::create(['name' => 'Manage Permissions']);
    Permission::create(['name' => 'Manage Holidays']);
    Permission::create(['name' => 'Manage Profile']);
    Permission::create(['name' => 'Manage Organizations']);
    Permission::create(['name' => 'Manage Designations']);
    Permission::create(['name' => 'Manage States']);
    Permission::create(['name' => 'Manage State Holidays']);
    Permission::create(['name' => 'Manage Users']);
    Permission::create(['name' => 'Manage Supervisors']);
    Permission::create(['name' => 'Manage Leaves']);
    Permission::create(['name' => 'Manage Leave Applications']);
  }
}
