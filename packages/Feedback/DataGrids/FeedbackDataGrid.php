<?php

namespace Feedback\DataGrids;

use Admin\Components\DataGrid;
use Admin\Contracts\DataGridContract;
use Feedback\Models\Feedback;


class FeedbackDataGrid extends DataGrid implements DataGridContract
{

    public $hasActions = true;

    public $searchable = ['name'];

    public static function url()
    {
        return '/admin/datagrid/feedback';
    }

    public function columns()
    {
        return [
            [
                'field' => 'id',
                'title' => '#',
                'width' => 50
            ],
            [
                'field' => 'name',
                'title' => 'Имя',
            ],
            [
                'field' => 'email',
                'title' => 'Email',
            ],
            [
                'field' => 'message',
                'title' => 'Сообщение',
            ],
            [
                'field' => 'created_at',
                'title' => 'Создан',
            ],
        ];
    }


    public function model()
    {
        return Feedback::class;
    }

    public function beforeRender($model)
    {

            $date = $model->created_at->formatLocalized('%d/%B/%Y');

            return  [
                'id' => $model->id,
                'name' => $model->name,
                'email' => $model->email,
                'message' => $model->message,
                'created_at' => "<div class='font-weight-bolder text-dark-50'>$date</div>",
            ];

    }

}
