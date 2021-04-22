<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
/**
 * @property bool|mixed url
 * @property mixed product_id
 * @mixin \Eloquent
 */
class Variations extends Model
{
		use Translatable;

		protected $table = 'shop_variations';

		public $searchable = ['title', 'description'];

		public $translatedAttributes = ['title', 'description'];

		public $translationModel = VariationTranslation::class;

    public $fillable = ['attribute_id','product_id','sku','price','quantity','locale','active','title','description','slug','sort',
        'out_of_stock','min_order','subtract_storage','out_of_stock_action','need_delivery','receipt_date','length','width','height','weight','tax_id',
        'upc','ean','jan','isbn','mpn','image', 'min_opt', 'price_opt'];

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getImageAttribute()
    {
        if (! $this->attributes['image']) {
            return asset('/images/placeholder-image.png');
        }

        return $this->attributes['image'];
    }

    public function values()
    {
			return $this->belongsToMany(AttributeValue::class,'shop_variation_values','variation_id','value_id');
//            ->withPivot('value_id')
//            ->using('Shop\Catalog\Models\Pivot\VariationValues');
    }

    public function images()
    {
        return $this->hasMany(VariationImage::class, 'variation_id', 'id');
    }

    public function getAttributeVariations(){

        $value = $this->values->first()->pivot;
        $ids = [];
        foreach($this->values as $value){
            $ids[] =  $value->pivot->value_id;
        }

        $query = DB::table('shop_attribute_values')
//            ->join('shop_attributes','shop_attributes.id','=','shop_attribute_values.attribute_id')
            ->join('shop_attribute_translations','shop_attribute_translations.attribute_id','=','shop_attribute_values.attribute_id')
            ->where('shop_attribute_translations.locale',app()->getLocale())
            ->where('shop_attribute_values.locale',app()->getLocale())
            ->whereIn('shop_attribute_values.id',$ids)
            ->select('title','value','product_id')
            ->get();
        return $query;

    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_variations_shop_categories','id','variation_id');
    }





}
