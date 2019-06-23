<?php

use Illuminate\Database\Seeder;
use App\Avatar;

class AvatarTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $avatar=new Avatar();
        $avatar->path = '/img/profiles_images/null.jpeg';
        $avatar->save();
        $num=0;
        do{
            $avatar=new Avatar();
            $avatar->path = '/img/profiles_images/'.$num.'.jpg';
            $avatar->save();
            $num++;
        }while ($num<6);
    }
}
