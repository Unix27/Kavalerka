<?php

namespace Customers\Models;

use Admin\Models\AdminRole;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Shop\Catalog\Models\FavoriteProduct;
use Shop\Orders\Models\Order;
use Shop\Catalog\Models\ViewedProduct;
use Shop\Reviews\Models\ProductsReview;

/**
 * Class Customer
 * @property mixed first_name
 * @property mixed last_name
 * @property mixed|string password
 * @property mixed username
 * @property mixed email
 * @property CustomerWallet wallet
 * @package Customers\Models
 * @mixin \Eloquent
 */
class Customer extends Authenticatable
{
    use HasApiTokens, Notifiable;

    public $searchable = ['first_name', 'last_name', 'middle_name', 'username',
        'email', 'phone', 'active'];

    protected $fillable = ['first_name', 'last_name', 'middle_name', 'username',
        'email', 'phone', 'active', 'notes', 'group_id', 'is_wholesale',
        'is_subscribed_to_news_letter', 'is_verified', 'additional_phone', 'gender','delivery_id','is_block','role_id','password','date_of_birth'];

    public function getTitleAttribute()
    {
        if (!empty($this->first_name) && !empty($this->last_name))
            return "$this->first_name $this->last_name";
        else return $this->username;
    }

    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'id');
    }

    public function delivery()
    {
        return $this->belongsTo(CustomerDeliveries::class);
    }

    public function payments()
    {
        return $this->hasMany(CustomerPayment::class, 'customer_id', 'id');
    }

    public function wallet()
    {
        return $this->hasOne(CustomerWallet::class, 'customer_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id', 'id');
    }

    public function favoriteProducts()
		{
    	return $this->hasMany(FavoriteProduct::class, 'customer_id', 'id');
		}

    public function viewedProducts()
		{
    	return $this->hasMany(ViewedProduct::class, 'customer_id', 'id');
		}

		public function favorites(){

			return $this->belongsToMany(Customer::class, 'favorite_products', 'customer_id', 'product_id');
		}

//		public function userProducts(){
//
//			return $this->belongsToMany(Customer::class, 'favorite_products',  'product_id','customer_id');
//		}
//
//		public function favoriteProducts(){
//
//			return $this->userProducts()->where('customer_id', auth()->user()->id)->first();
//		}

    public function phones()
    {
        return $this->hasMany(PhoneNumber::class, 'customer_id', 'id');
    }

    public function role(){
        return $this->belongsTo(AdminRole::class);
    }

    public function review(){
    	return $this->hasMany(ProductsReview::class, 'customer_id', 'id');
		}

//    public function getDateOfBirthAttribute($date)
//    {
//        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d/m/Y');
//    }



    public function getDateOfBirth()
    {
        if($this->date_of_birth) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->date_of_birth)->format('d.m.Y');
        }else{
            gmdate('d/m/Y');
        }
    }


//    public function getCreatedAtAttribute($date)
//    {
//        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y');
//    }

}
