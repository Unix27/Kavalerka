<?php

use Admin\database\seeds\AdminPermissionsTableSeeder;
use Admin\database\seeds\AdminRolesTableSeeder;
use Admin\database\seeds\AdminsTableSeeder;
use Admin\database\seeds\SettingsSeeder;
use Blog\database\seeds\BlogPermissionsSeeder;
use Blog\database\seeds\PostCategoriesTableSeeder;
use Blog\database\seeds\PostsTableSeeder;
use Illuminate\Database\Seeder;
use Localization\database\seeds\LocalesTableSeeder;
use Pages\database\seeds\PagesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*ADMIN*/

        $this->call(AdminsTableSeeder::class);
        $this->call(AdminRolesTableSeeder::class);
        $this->call(AdminPermissionsTableSeeder::class);

        /*LOCALIZATION*/

        $this->call(LocalesTableSeeder::class);

        /*BLOG*/

        $this->call(PostCategoriesTableSeeder::class);
        $this->call(PostsTableSeeder::class);

        /*Customers*/

        $this->call(\Customers\database\seeds\GroupsSeeder::class);
        $this->call(\Customers\database\seeds\CustomersSeeder::class);

        /*PAGE*/
        //$this->call(PagesSeeder::class);

        /*SHOP*/

        $this->call(\Shop\Catalog\Database\Seeds\StatusSeeder::class);

        $this->call(\Shop\Catalog\Database\Seeds\AttributeGroupsSeeder::class);
        $this->call(\Shop\Catalog\Database\Seeds\AttributesSeeder::class);

        $this->call(\Shop\Catalog\Database\Seeds\CategoriesSeeder::class);
        $this->call(\Shop\Catalog\Database\Seeds\BrandsSeeder::class);

        $this->call(\Shop\Catalog\Database\Seeds\ProductsSeeder::class);

        $this->call(\Shop\Orders\Database\Seeds\OrdersSeeder::class);

        $this->call(\Shop\Returns\Database\Seeds\ReturnReasonsSeeder::class);
        $this->call(\Shop\Returns\Database\Seeds\ReturnStatusesSeeder::class);


        $this->call( \Core\Settings\Database\Seeds\StorageStatusSeeder::class);
        $this->call( \Core\Settings\Database\Seeds\UnitWeightSeeder::class);
        $this->call( \Core\Settings\Database\Seeds\UnitsSeeder::class);
        $this->call( \Core\Settings\Database\Seeds\CurrencySeeder::class);


    }
}
