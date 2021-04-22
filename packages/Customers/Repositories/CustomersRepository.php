<?php


namespace Customers\Repositories;
use Customers\Models\Customer;
use Customers\Models\Customer as Model;
use Customers\Models\CustomerAddress;
use Customers\Models\CustomerDeliveries;

class CustomersRepository
{

    public function __construct()
    {

    }

    public function all(array $attributes)
    {
        return Model::with('addresses')->get()->toArray();
    }

    public function create(array $attributes)
    {
        $model = new Model;

        if(isset($attributes['is_block'])){
            $attributes['is_block'] = !$attributes['is_block'];
        }else{
            $attributes['is_block'] = true;
        }

        $model->fill($attributes);



        if(empty($attributes['password']))
            $attributes['password'] = '123456';
        $model->password = bcrypt($attributes['password']);
        $model->save();


        if(isset($attributes['addresses'])){
            $address = new CustomerAddress();
            $address->address1 = $attributes['addresses']['address1'];
            $address->city = $attributes['addresses']['city'];
            $address->country = $attributes['addresses']['country'];
            $address->postcode = $attributes['addresses']['postcode'];
            $address->state = $attributes['addresses']['state'];
            $address->customer_id = $model->id;

            $address->save();
        }

        if(isset($attributes['delivery'])){
            $delivery = new CustomerDeliveries();
            $delivery->fill($attributes['delivery']);
            $delivery->save();
            $delivery_id =  $delivery->id;
        }else{
            $delivery_id = null;
        }


        $model->delivery_id = $delivery_id;
        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {
        $model->fill($attributes);

        if(isset($attributes['addresses'][0])){
           $address = CustomerAddress::where('customer_id','=',$attributes['id'])->first();
           $attributes['addresses'][0]['customer_id'] = $attributes['id'];
           if($address){
                CustomerAddress::where('customer_id',$attributes['id'])->update($attributes['addresses'][0]);
           }else{
                CustomerAddress::create($attributes['addresses'][0]);
           }
        }

        if(isset($attributes['delivery'])){
            if(isset($attributes['delivery']['id'])){
                $delivery = CustomerDeliveries::find($attributes['delivery']['id']);
            }else{
                $delivery = new CustomerDeliveries();
            }
            $delivery->fill($attributes['delivery']);
            $delivery->save();
            $delivery_id =  $delivery->id;
        }else{
            $delivery_id = null;
        }

        $model->delivery_id = $delivery_id;
        $model->save();

        return $model;
    }

    public function findByEmail($email)
    {
        return Customer::where('email', $email)->first();
    }

    public function getForSelect()
    {
        $customers = Model::all();

        $result = [];

        foreach ($customers as $customer) {
            $result[$customer->id] = $customer->first_name . ' ' . $customer->last_name . ' (' . $customer->email . ')';
        }

        return $result;
    }
}
