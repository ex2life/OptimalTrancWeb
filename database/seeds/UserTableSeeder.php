<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_driver = Role::where('name', 'driver')->first();
        $role_loader = Role::where('name', 'loader')->first();
        $role_manager = Role::where('name', 'manager')->first();

        $mobile1=\App\Mobile::where('id','1')->first();
        $mobile2=\App\Mobile::where('id','2')->first();
        $mobile3=\App\Mobile::where('id','3')->first();
        $mobile4=\App\Mobile::where('id','4')->first();
        $mobile5=\App\Mobile::where('id','5')->first();
        $mobile6=\App\Mobile::where('id','6')->first();

        $avatar1=\App\Avatar::where('id','2')->first();
        $avatar2=\App\Avatar::where('id','3')->first();
        $avatar3=\App\Avatar::where('id','4')->first();
        $avatar4=\App\Avatar::where('id','5')->first();
        $avatar5=\App\Avatar::where('id','6')->first();
        $avatar6=\App\Avatar::where('id','7')->first();

        $driver = new User();
        $driver->name = 'Дизель Вин Алексеевич';
        $driver->email = 'driver@ex2life.com';
        $driver->password = bcrypt('secret');
        $driver->save();
        $driver->roles()->attach($role_driver);
        $driver->mobiles()->attach($mobile1);
        $driver->avatars()->attach($avatar1);

        $driver = new User();
        $driver->name = 'Ахмед Вах Водила';
        $driver->email = 'driver2@ex2life.com';
        $driver->password = bcrypt('secret');
        $driver->save();
        $driver->roles()->attach($role_driver);
        $driver->mobiles()->attach($mobile4);
        $driver->avatars()->attach($avatar2);

        $driver = new User();
        $driver->name = 'Шамаич Шамай Шамаевич';
        $driver->email = 'driver3@ex2life.com';
        $driver->password = bcrypt('secret');
        $driver->save();
        $driver->roles()->attach($role_driver);
        $driver->mobiles()->attach($mobile5);
        $driver->avatars()->attach($avatar3);

        $driver = new User();
        $driver->name = 'Давидыч Эрик Спортсмен';
        $driver->email = 'driver4@ex2life.com';
        $driver->password = bcrypt('secret');
        $driver->save();
        $driver->roles()->attach($role_driver);
        $driver->mobiles()->attach($mobile6);
        $driver->avatars()->attach($avatar4);

        $loader = new User();
        $loader->name = 'Роберт Брюс Бэннер';
        $loader->email = 'loader@ex2life.com';
        $loader->password = bcrypt('secret');
        $loader->save();
        $loader->roles()->attach($role_loader);
        $loader->mobiles()->attach($mobile2);
        $loader->avatars($avatar5)->attach($avatar5);

        $manager = new User();
        $manager->name = 'Крестный Отец Семен';
        $manager->email = 'manager@ex2life.com';
        $manager->password = bcrypt('secret');
        $manager->save();
        $manager->roles()->attach($role_manager);
        $manager->mobiles()->attach($mobile3);
        $manager->avatars()->attach($avatar6);
    }
}
