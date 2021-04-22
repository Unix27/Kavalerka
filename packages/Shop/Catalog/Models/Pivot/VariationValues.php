<?php
namespace Shop\Catalog\Models\Pivot;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Shop\Catalog\Models\AttributeValue;

class VariationValues extends Pivot
{
    public function attrValue(){
        return $this->belongsTo(AttributeValue::class,'id','value_id');
    }
}
