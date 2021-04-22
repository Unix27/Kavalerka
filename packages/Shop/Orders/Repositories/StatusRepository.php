<?php


namespace Shop\Orders\Repositories;

use Shop\Orders\Models\Order;
use Shop\Orders\Models\OrderItem;
use Customers\Repositories\CustomersRepository;
use Shop\Orders\Models\Status;

class StatusRepository
{
    protected $locale;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
    }

    public function update(Status $status, array $attributes)
    {
        $status->fill($attributes);
        $status->save();

        return $status;
    }
}
