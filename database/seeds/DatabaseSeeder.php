<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Sensor;
use App\Report;
use App\City;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // City

        // Dublin
        $city = new City;
        $city->accuweather_id = 207931;
        $city->save();

        // Dinan
        $city = new City;
        $city->accuweather_id = 132541;
        $city->save();


        // Create User
        $faker = Faker\Factory::create();

        User::insert([
            'name'      => 'Nicolas Guilloux',
            'email'     => 'novares.x@gmail.com',
            'password'  => bcrypt('imafla'),
            'birthday'  => '1994-06-30',
            'avatar'    => 'O5kp2F3Vzl5rpw6Q.jpg',
            'role'      => 10,
            'bio'       => $faker->realText(),
            'city_id'   => 2
        ]);

        $faker = Faker\Factory::create();
        User::insert([
            'name'      => 'Frank Boehme',
            'email'     => 'f.boehme@cs.ucc.ie',
            'password'  => bcrypt('fboehme'),
            'bio'       => $faker->realText(),
            'city_id'   => 1
        ]);

        $faker = Faker\Factory::create();
        User::insert([
            'name' => 'John Doe',
            'email' => 'john@gmail.com',
            'password' => bcrypt('imafla'),
            'bio'      => $faker->realText()
        ]);

        $faker = Faker\Factory::create();
        User::insert([
            'name' => 'The tester',
            'email' => 'test@test.com',
            'password' => bcrypt('testtest'),
            'bio'      => $faker->realText()
        ]);


        // Create Sensors

        #Electricity
        Sensor::insert([
            'name' => 'House',
            'driverName' => 'Electricity',
            'place' => 'Closet'
        ]);

        Sensor::insert([
            'name' => 'Kitchen',
            'driverName' => 'Electricity',
            'place' => 'Kitchen',
            'parent_id' => 1
        ]);

        Sensor::insert([
            'name' => 'Fridge',
            'driverName' => 'Electricity',
            'place' => 'Kitchen',
            'parent_id' => 2
        ]);

        Sensor::insert([
            'name' => 'Microwave',
            'driverName' => 'Electricity',
            'place' => 'Kitchen',
            'parent_id' => 2
        ]);

        Sensor::insert([
            'name' => 'Computer',
            'driverName' => 'Electricity',
            'place' => 'Living room',
            'parent_id' => 1
        ]);

        # Water
        $main = Sensor::insert([
            'name' => 'Main Water Supply',
            'driverName' => 'Water',
            'place' => 'Washroom'
        ]);

        Sensor::insert([
            'name' => 'Shower',
            'driverName' => 'Water',
            'place' => 'Bathroom',
            'parent_id' => 6
        ]);

        # Waste
        Sensor::insert([
            'name' => 'General garbage',
            'driverName' => 'Waste',
            'place' => 'Kitchen'
        ]);


        // Create reports
        function addRandomNumber(&$item, $key) {
            $item = $item + rand(10, 100);
        }

        for($d=20; $d<30; $d++) {

            # Electricity
                # Computer
                $array = range(0, 200);
                shuffle($array);

                Report::insert([
                    'date'      => '2018-06-' . $d,
                    'sensor_id' => 5,
                    'average'   => array_sum($array)/count($array),
                    'min'       => min($array),
                    'max'       => max($array),
                    'total'     => array_sum($array),
                    'data'      => json_encode($array)
                ]);

                # House
                array_walk($array, 'addRandomNumber');
                Report::insert([
                    'date'      => '2018-06-' . $d,
                    'sensor_id' => 1,
                    'average'   => array_sum($array)/count($array),
                    'min'       => min($array),
                    'max'       => max($array),
                    'total'     => array_sum($array),
                    'data'      => json_encode($array)
                ]);

            # Waste
                $array = range(0, 20);
                shuffle($array);

                Report::insert([
                    'date'      => '2018-06-' . $d,
                    'sensor_id' => 8,
                    'average'   => array_sum($array)/count($array),
                    'min'       => min($array),
                    'max'       => max($array),
                    'total'     => array_sum($array),
                    'data'      => json_encode($array)
                ]);

            # Water
                # Shower
                $array = range(0, 100);
                shuffle($array);

                Report::insert([
                    'date'      => '2018-06-' . $d,
                    'sensor_id' => 6,
                    'average'   => array_sum($array)/count($array),
                    'min'       => min($array),
                    'max'       => max($array),
                    'total'     => array_sum($array),
                    'data'      => json_encode($array)
                ]);

                # House
                array_walk($array, 'addRandomNumber');
                Report::insert([
                    'date'      => '2018-06-' . $d,
                    'sensor_id' => 3,
                    'average'   => array_sum($array)/count($array),
                    'min'       => min($array),
                    'max'       => max($array),
                    'total'     => array_sum($array),
                    'data'      => json_encode($array)
                ]);
        }
    }
}
