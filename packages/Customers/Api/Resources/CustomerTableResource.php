<?php


namespace Customers\Api\Resources;


use Customers\Models\Customer;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerTableResource extends JsonResource
{
    public function toArray($request)
    {

        $orders_total = $this->orders()->sum('total_price');
				$favorite_products = Customer::find($this->id)->favoriteProducts()->get();
				$viewed_products = Customer::find($this->id)->viewedProducts()->get();
//        $favorite_products = $this->()->get();

        return [
            "id"                => $this->id,
            "first_name"        => $this->first_name,
            "last_name"         => $this->last_name,
            "email"             => $this->email,
            "phone"             => $this->phone,
            "orders_total"      => $orders_total,
            'addresses'         => $this->addresses,
            'delivery'          => $this->delivery,
            'is_block'          => $this->is_block,
            'active'            => $this->is_block,
            'date'              => $this->created_at->format('d.m.Y'),
            'date_of_birth'     => $this->date_of_birth,
            'gender'            => $this->gender,
						'favorite_products' => $favorite_products,
						'viewed_products'   => $viewed_products,
//            'role' => 'Пользователь',
        ];
    }
}
