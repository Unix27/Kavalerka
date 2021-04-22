<?php


namespace Shop\Promocodes\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Shop\Catalog\Models\Category;
use Shop\Promocodes\Models\PromocodesBrand;
use Shop\Promocodes\Models\PromocodesCategories;
use Shop\Promocodes\Models\PromocodesProduct;
use Shop\Catalog\Models\Product;

class PromocodesResource extends JsonResource
{
	public function toArray($request)
	{

		$categories = Category::where('parent_id', '=', null)->get();

		$promo_brands = PromocodesBrand::where('promocode_id', '=', $this->id)->pluck('brand_id');
		$promo_products = PromocodesProduct::where('promocode_id', '=', $this->id)->pluck('product_id');
		$promo_categories = PromocodesCategories::where('promocode_id', '=', $this->id)->pluck('category_id');

		$products = Product::whereIn('id', $promo_products)->get();

		if($this->type == 'opt'){
			$this->type = 0;
		}

		return [
			"id"            => $this->id,
			'type'          => $this->type,
			'active'        => $this->active,
			'promocode'     => $this->promocode,
			'date_start'    => $this->date_start,
			'date_end'      => $this->date_end,
			'discount'      => $this->discount,
			'is_percent'    => $this->is_percent,
			'quantity'      => $this->quantity,
			'min_price'     => $this->min_price,

			'brands'        => $promo_brands,
			'products'      => $products,
			'categories'    => $promo_categories,

			'all_categories'=> $this->treeCategories($categories),
		];
	}

	public function treeCategories($categories){
		$tree = [];

		foreach($categories as $cat){

			if(count($cat->children)){
				$children = [];
				$children['label'] = $cat->title;
				$children['id'] = $cat->id;
				$children['children'] = $this->treeCategories($cat->children);

				$tree[] = (object)$children;
			}else{
				$tree[] = (object)[
					'label' => $cat->title,
				  'id'   => $cat->id,
				];
			}

		}

		return $tree;
	}
}
