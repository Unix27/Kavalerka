<?php

$admin_path = env('ADMIN_PATH');

Route::get("$admin_path/customers/{id}/login", 'Customers\Http\Controllers\CustomersController@login')
    ->name('admin.customers.login');

Route::resource("$admin_path/customers", 'Customers\Http\Controllers\CustomersController')
    ->names('admin.customers');

Route::resource("$admin_path/customer_groups", 'Customers\Http\Controllers\CustomerGroupsController')
    ->names('admin.customer_groups');
