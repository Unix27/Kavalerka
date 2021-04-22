<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Shop\Catalog\Models\Relations\HasManySyncable;
use Customers\Models\Customer;
use Shop\Reviews\Models\ProductsReview;

/**
 * Class Product
 * @property mixed categories
 * @property mixed group
 * @property mixed id
 * @property mixed brand_id
 * @property mixed category_id
 * @property mixed images
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Product extends Model
{
    use Translatable;

    protected $table = 'shop_products';

    public $searchable = ['title', 'description','sku','slug'];

    public $translatedAttributes = ['title', 'description', 'characteristics',
        'meta_title', 'meta_description', 'meta_keywords'];

    public $translationModel = ProductTranslation::class;

    protected $fillable = [
        'sku', 'active', 'sort', 'quantity', 'price', 'model', 'brand_id', 'image',
        'out_of_stock', 'min_order', 'subtract_storage', 'out_of_stock_action',
        'need_delivery', 'receipt_date', 'tax_id', 'slug',
        'length', 'width', 'height', 'weight',
        'upc', 'ean', 'jan', 'isbn', 'mpn','is_sale','is_miniland','popularity','unit_id','unit_weight_id','status_id', 'price_opt', 'min_opt'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'shop_products_shop_categories');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function attributesGet()
    {
        return $this->belongsToMany(AttributeValue::class,
            'shop_products_shop_attributes','product_id','attribute_id'
        );
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class, 'product_id', 'id');
    }

    public function relations()
    {
        return $this->hasMany(Relations::class, 'current_product_id', 'id');
    }

    public function discounts()
    {
        return $this->hasMany(Discounts::class, 'product_id', 'id');
    }

    public function variations()
    {
        return $this->hasMany(Variations::class,'product_id','id');
    }

		public function userFavorites(){

			return $this->belongsToMany(Customer::class, 'favorite_products',  'product_id','customer_id');
		}

		public function favoriteProduct(){

			return $this->userFavorites()->where('customer_id',auth()->user()->id)->first();
		}

    public function valuesSync()
    {
        return $this->hasManySync(AttributeValue::class, 'attribute_id', 'id');
    }

    public function hasManySync($related, $foreignKey = null, $localKey = null)
    {
        $instance = $this->newRelatedInstance($related);

        $foreignKey = $foreignKey ?: $this->getForeignKey();

        $localKey = $localKey ?: $this->getKeyName();

        return new HasManySyncable(
            $instance->newQuery(), $this, $instance->getTable().'.'.$foreignKey, $localKey
        );
    }


    public function getSalePrice($variation = null){

        $discount = $this->discounts()
            ->where('date_start','<=',\Carbon\Carbon::now()->format('Y/m/d H:i:s'))
            ->where('date_end','>=',\Carbon\Carbon::now()->format('Y/m/d H:i:s'))
            ->first();

        if(!$variation) {
            $variation = Variations::where('product_id', $this->id)->first();
        }

        if($variation && $variation->values->count()) {
            if($discount){
                if ($discount->is_percent) {
                    return ((object)[
                        'price' => $variation->price - $variation->price * $discount->price / 100,
                        'percent_status' => true,
                        'discount' => number_format($discount->price, 0, ',', ' '),
                        'product_price' => $variation->price
                    ]);
                } else {
                    return ((object)[
                        'price' => $variation->price - $discount->price,
                        'percent_status' => false,
                        'discount' => $discount->price,
                        'product_price' => $variation->price
                    ]);
                }
            }
        }else{
            if ($discount) {
                if ($discount->is_percent) {
                    return ((object)[
                        'price' => $this->price - $this->price * $discount->price / 100,
                        'percent_status' => true,
                        'discount' => number_format($discount->price, 0, ',', ' '),
                        'product_price' => $this->price
                    ]);
                } else {
                    return ((object)[
                        'price' => $this->price - $discount->price,
                        'percent_status' => false,
                        'discount' => $discount->price,
                        'product_price' => $this->price
                    ]);
                }
            }
        }


        return isset($variation) ? $variation->price : $this->price;
    }

		public function viewed(){

    	return $this->belongsToMany(Customer::class, 'viewed_products', 'product_id', 'customer_id');
		}

		public function reviews(){
			return $this->hasMany(ProductsReview::class,'product_id','id');
		}

	public function useVar(){
		return $this->belongsToMany(Attribute::class,'shop_products_shop_attr','product_id','attribute_id');
	}


	public function getParentsAttribute()
	{
		$parents = collect([]);



		$parent = $this->categories;
		dd($parent);

		while(!is_null($parent)) {
			$parents->push($parent);
			$parent = $parent->parent;
		}
		return $parents;
	}

}

