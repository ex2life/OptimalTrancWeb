<?php

use Illuminate\Database\Seeder;
use App\City;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = ['Саранск', 'Москва', 'Санкт-Петербург', 'Пенза', 'Екатеринбург', 'Сочи', 'Тбилиси', 'Самара', 'Красноярск', 'Магадан', 'Владивосток', 'Краснодар', 'Нижний Новгород', 'Ульяновск', 'Пермь', 'Калуга'];
        foreach ($cities as $city_arr) {
            $city = new City();
            $city->name = $city_arr;
            $city->count_shops = rand(1, 20);
            $city->money = rand(50, 15000);
            $city->save();
        }
    }
}
