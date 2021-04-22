<?php

namespace Customers\database\seeds;

use Blog\Models\BlogCategory;
use Blog\Models\BlogCategoryTranslation;
use Customers\Models\Customer;
use Customers\Models\CustomerAddress;
use Customers\Models\CustomerGroup;
use DB;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create();


        $customer = new Customer();

        $customer->fill([
            'first_name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'email' => 'admin@gmail.com',
            'phone' => $faker->phoneNumber,
            'additional_phone' => mt_rand(0, 1) ? $faker->phoneNumber : null,
            'password' => bcrypt('admin'),
            'is_verified' => mt_rand(0, 1),
            'role_id' => 1
        ]);

        $customer->group_id = 1;

        $customer->save();

        $address = new CustomerAddress();
        $address->customer_id = $customer->id;
        $address->address1 = $faker->address;
        $address->country = $faker->country;
        $address->state = $faker->state;
        $address->city = $faker->city;
        $address->postcode = $faker->postcode;
        $address->save();


        for($i = 0; $i < 100; $i++) {
            $customer = new Customer();
            $customer->fill([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'additional_phone' => mt_rand(0, 1) ? $faker->phoneNumber : null,
                'password' => bcrypt('123456'),
                'is_verified' => mt_rand(0, 1),
                'role_id' => 5

            ]);

            $customer->group_id = 1;

            $customer->save();

            $address = new CustomerAddress();
            $address->customer_id = $customer->id;
            $address->address1 = $faker->address;
            $address->country = $faker->country;
            $address->state = $faker->state;
            $address->city = $faker->city;
            $address->postcode = $faker->postcode;
            $address->save();
        }
    }
}
