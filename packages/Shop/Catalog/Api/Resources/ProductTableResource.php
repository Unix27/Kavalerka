<?php


namespace Shop\Catalog\Api\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class ProductTableResource extends JsonResource
{
    public function toArray($request)
    {

        $attributes = $this->attributesGet;

        foreach ($attributes as $key => $attribute) {
            foreach ($this->attributeValues()->where('locale', app()->getLocale())->get() as $attributeValue) {
                if($attribute->id == $attributeValue->attribute_id) {
                    $attributes[$key]->value = $attributeValue->value;
                    //dd($attributes[$key]->value, $attributeValue->value);
                }
            }
        }

        //dd($attributes);



        return [
            "id" => $this->id,
            "sku" => $this->sku,
            "description" => $this->description,
						"characteristics" => $this->characteristics,
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
            "meta_title" => $this->meta_title,
            "meta_description" => $this->meta_description,
            "meta_keywords" => $this->meta_keywords,
            "categories" => $this->categories->implode('title',', '),
            "attributes" => $attributes,
            'discounts' => $this->discounts,
            'variations' => $this->variations()->with('product.categories')->whereTranslationLike('locale',app()->getLocale())->get()
        ];
    }
}
