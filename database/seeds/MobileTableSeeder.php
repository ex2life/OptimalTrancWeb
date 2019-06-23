<?php

use Illuminate\Database\Seeder;
use App\Mobile;

class MobileTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $num=0;
        do{
            $mobile=new Mobile();
            $mobile->number = rand(79000000000, 79999999999);
            $mobile->save();
            $num++;
        }while ($num<6);
    }
}
