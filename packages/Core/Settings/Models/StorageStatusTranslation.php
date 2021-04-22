<?php

namespace Core\Settings\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AttributeGroup
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class StorageStatusTranslation extends Model
{
    protected $table = 'shop_storage_statuses_translations';

    protected $fillable = ['name'];




}
