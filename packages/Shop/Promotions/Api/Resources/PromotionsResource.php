<?php


namespace Shop\Promotions\Api\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Shop\Catalog\Models\Category;
use Shop\Promotions\Models\PromotionsBrand;
use Shop\Promotions\Models\PromotionsCategories;
use Shop\Promotions\Models\PromotionsProduct;
use Shop\Promotions\Models\PromotionsCategory;
use Shop\Catalog\Models\Product;

class PromotionsResource extends JsonResource
{
	public function toArray($request)
	{

		$categories = Category::where('parent_id', '=', null)->get();

		$promo_brands = PromotionsBrand::where('promotion_id', '=', $this->id)->pluck('brand_id');
		$promo_products = PromotionsProduct::where('promotion_id', '=', $this->id)->pluck('product_id');
		$promo_categories = PromotionsCategories::where('promotion_id', '=', $this->id)->pluck('category_id');

		$products = Product::whereIn('id', $promo_products)->get();

		if($this->type == 'opt'){
			$this->type = 0;
		}

		return [
			"id"            => $this->id,
			'type'          => $this->type,
			'image'					=> $this->image,
			'description'   => $this->description,
			'date_start'    => $this->date_start,
			'date_end'      => $this->date_end,
			'main_category' => $this->main_category,
			'category_id'   => $this->category_id,
			'active'        => $this->active,
			'discount'      => $this->discount,
			'is_percent'    => $this->is_percent,
			'upc'           => $this->upc,
			'ean'           => $this->ean,
			'jan'           => $this->jan,
			'isbn'          => $this->isbn,
			'mpn'           => $this->mpn,
			'title'         => $this->title,

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
