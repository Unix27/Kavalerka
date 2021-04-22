<?php

namespace Core\Settings\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class StorageStatus extends Model
{
    use Translatable;

    public $table = 'shop_storage_statuses';

    public $translatedAttributes = ['name'];

    public $translationModel = StorageStatusTranslation::class;
}
