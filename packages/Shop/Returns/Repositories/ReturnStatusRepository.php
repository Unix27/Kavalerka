<?php


namespace Shop\Returns\Repositories;


use Customers\Repositories\CustomersRepository;
use Shop\Returns\Models\ReturnStatuses as Model;

class ReturnStatusRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function create(array $attributes)
    {
        $returns = new Model();
        $returns->fill($attributes);
        $returns->save();


        return $returns;
    }

    public function update(Model $model, array $attributes)
    {
        $model->fill($attributes);
        $model->save();

        return $model;
    }
}
