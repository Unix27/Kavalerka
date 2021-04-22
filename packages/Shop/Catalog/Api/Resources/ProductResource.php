<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Shop\Catalog\Models\Attribute;

class ProductResource extends JsonResource
{
    public function toArray($request)
    {

//        $test = $attributes = $this->attributesGet()->where('locale',app()->getLocale())->get();
        $arr = [];
        $attributesKey = [];
        $keys = [];



//        foreach ($attributes as $key => $attribute) {
//            foreach ($this->attributeValues()->where('locale', app()->getLocale())->get() as $attributeValue) {
//                if($attribute->id == $attributeValue->attribute_id) {
//                    // $attributes[$key]->value = $attributeValue->value;
//                    $arr[$key][] = $attributeValue->value;
//                    $keys[$key][$attributeValue->id] = $attributeValue->value;
//                    // $attributes[$key]->value = $arr[$key];
//
//                    $attributes[$key]->value = [
//                        'id' => $keys[$key],
//                        'values' => $arr[$key]
//                    ];
//
//
//                    $attributesKey[$key][$attributeValue->id] = $attributeValue->value;
//                    //dd($attributes[$key]->value, $attributeValue->value);
//                }
//            }
//        }


        $files = [];
        foreach ($this->images as $key => $value) {
           $files[] = [
                'uid' => '-'.($key+1),
                'name' => uniqid().'.png',
                'status' => 'done',
                'url' => $value->url
           ];
        }


        $attributes = Attribute::get();

        $attributesValues = $this->attributesGet()->get()->groupBy('attribute_id');
        $selectedAttrVal = [];

        $attrVar = $this->useVar()->get()->keyBy('id');

        foreach($attributes as $attr){
            if(!isset($attributesValues[$attr->id])){
                $selectedAttrVal[$attr->id]['ids'] = null;
                $selectedAttrVal[$attr->id]['show'] = 0;
                $selectedAttrVal[$attr->id]['use_var'] = 0;
                $selectedAttrVal[$attr->id]['attr_id'] = $attr->id;
            }else{
                foreach($attributesValues[$attr->id] as $k => $val){
                    $selectedAttrVal[$attr->id]['ids'][] = $val->id;
                    $selectedAttrVal[$attr->id]['show'] = $val->pivot->show;
                    $selectedAttrVal[$attr->id]['use_var'] = isset($attrVar[$attr->id])?$attr->id:0;
                    $selectedAttrVal[$attr->id]['attr_id'] = $attr->id;
                }
            }
        }




//        $selectedAttrVal = [];
//        foreach($this->attributesGet()->get()->groupBy('attribute_id') as $key => $arr){
//            foreach($arr as $k => $val){
//                $selectedAttrVal[$key][$k] = $val;
//                $selectedAttrVal[$key][$k]['label'] = $val->title;
//            }
//        }


        return [
            'attrVar' => $attrVar,
            'test' => $selectedAttrVal,
            'characteristic' => $this->characteristic,
            'selectedAttrVal' => collect($selectedAttrVal),
            "attributesKey"=>$attributesKey,
            "id" => $this->id,
            "sku" => $this->sku,
            "description" => $this->description,
            "quantity" => $this->quantity,
            "image" => $this->image,
            "price" => $this->price,
            "active" => $this->active,
            "sort" => $this->sort,
            "brand_id" => $this->brand_id,
            "model" => $this->model,
            "out_of_stock" => $this->out_of_stock,
            "min_order" => $this->min_order,
            "subtract_storage" => $this->subtract_storage,
            "out_of_stock_action" => $this->out_of_stock_action,
            "need_delivery" => $this->need_delivery,
            "receipt_date" => $this->receipt_date,
            "length" => $this->length,
            "width" => $this->width,
            "height" => $this->height,
            "weight" => $this->weight,
            "tax_id" => $this->tax_id,
            "upc" => $this->upc,
            "ean" => $this->ean,
            "jan" => $this->jan,
            "isbn" => $this->isbn,
            "mpn" => $this->mpn,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "title" => $this->title,
            "slug" => $this->slug,
						'min_opt' => $this->min_opt,
						'price_opt' => $this->price_opt,
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "categories" => $this->categories->pluck('id'),
//            "attributes" => $attributes,
            "files" => $files,
            'discounts' => $this->discounts,
            'variations' => $this->variations,
            'unit_id' => $this->unit_id,
            'unit_weight_id' => $this->unit_weight_id,
            'status_id' => $this->status_id,
            'promotions' => $this->promotions,
            'news' => $this->news,
            'sales' => $this->sales,
        ];
    }
}
