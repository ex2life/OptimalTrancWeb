<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_driver = new Role();
        $role_driver->name = 'driver';
        $role_driver->description = 'Водитель';
        $role_driver->save();

        $role_employee = new Role();
        $role_employee->name = 'loader';
        $role_employee->description = 'Грузчик';
        $role_employee->save();

        $role_manager = new Role();
        $role_manager->name = 'manager';
        $role_manager->description = 'Менеджер';
        $role_manager->save();
    }
}
