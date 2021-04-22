<?php

namespace Torgsoft\Models;

use Illuminate\Support\Facades\Hash;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeValue;
use Shop\Catalog\Models\Brand;
use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Product;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Shop\Catalog\Models\Product as Model;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Repositories\ProductsRepository as Repository;


class Import implements ToCollection, WithCustomCsvSettings, WithHeadingRow
{
	protected $repository;

	public function __construct()
	{
//		$this->middleware('admin');
		$this->repository = app(Repository::class);
	}

	public function collection(Collection $rows)
	{
		$attributes = Attribute::join('shop_attribute_translations', 'shop_attribute_translations.attribute_id', '=', 'shop_attributes.id')
				->join('shop_attribute_values', 'shop_attribute_values.attribute_id', '=', 'shop_attributes.id')
				->join('shop_attribute_values_translations', 'attribute_value_id', '=', 'shop_attribute_values.id')
				->where('shop_attribute_translations.locale', '=', 'ru')
				->where('shop_attribute_values_translations.locale', '=', 'ru')
				->select('shop_attribute_values_translations.title as title', 'shop_attribute_values_translations.attribute_value_id as id')
				->pluck('title', 'id');
		$categories = Category::join('shop_category_translations', 'shop_category_translations.category_id', '=', 'shop_categories.id')
				->where('locale', '=', 'ru')
				->select('title', 'shop_categories.id as id')
				->pluck('title','id');
		$brands = Brand::join('shop_brand_translations', 'shop_brand_translations.brand_id', '=', 'shop_brands.id')
				->where('locale', '=', 'ru')
				->pluck('title', 'shop_brands.id');

		$filterRows = [];
// Sorting for modelId

		foreach($rows as $row){
			if($row['modelid']){
				$filterRows[$row['modelid']][] = $row;
			}else{
				$filterRows[][] = $row;
			}
		}

		$products = [];

// Create new right array to create/update function of product repository

		foreach($filterRows as $row){
			$product = [];
			if(count($row) > 1){
				if(isset($row[0]['categories'])){
					$ids_categories = explode(',', $row[0]['categories']);
					$found_items = [];
					foreach($ids_categories as $cat){
						$search_items = array_search($cat, $categories->toArray());
						if($search_items){
							$found_items[] = $search_items;
						}
					}
					$product['categories'] = $found_items;
				}

				if(isset($row[0]['brand'])){
					$search_brand = array_search($row[0]['brand'], $brands->toArray());
					if($search_brand){
						$product['brand'] = $search_brand;
					}else{
						$product['brand'] = null;
					}
				}

				$product['id']               = $row[0]['id'];
				$product['title']            = $row[0]['title'] ?? $row[0]['title_long'];
				$product['meta_title']       = $row[0]['title'] ?? $row[0]['title_long'];
				$product['description']      = $row[0]['description'];
				$product['meta_description'] = $row[0]['description'];
				$product['price']            = $row[0]['price'];
				$product['min_opt']          = $row[0]['min_opt'];
				$product['price_opt']        = $row[0]['wholesale_price'];
				$product['quantity']         = $row[0]['quantity'];
				$product['sku']              = $row[0]['sku'] . $row[0]['id'] . 22;
				$product['active']           = 1;
				$product['status_id']        = 1;
				$product['sort']             = 100;
				if($row[0]['size']){
					$product['characteristic'] = 'Размер: ' . $row[0]['size'];
				}
				if($row[0]['title']){
					$product['slug']           = \Str::slug($row[0]['title']);
				} else{
					$product['slug']           = \Str::slug($row[0]['title_long']);
				}

				$selectedAttrVal = [];
				$variations = [];

				foreach($row as $key => $item){

					$var = [];

					if(isset($item['size'])){
						$attribute = AttributeValue::whereTranslationLike('title', $item['size'])->first();
						$product['attrVar'][] = $attribute->attribute;
						$attr_value = $attribute->id;
						$selectedAttrVal[$attribute->attribute->id]['ids'][] = $attr_value;
						$selectedAttrVal[$attribute->attribute->id]['show'] = true;
//						$selectedAttrVal[$attribute->attribute->id]['use_var'] = isset($attrVar[$attr->id])?$attr->id:0;
						$selectedAttrVal[$attribute->attribute->id]['use_var'] = $attribute->attribute->id;
						$selectedAttrVal[$attribute->attribute->id]['attr_id'] = $attribute->attribute->id;
					}

					if(isset($item['categories'])){
						$ids_categories = explode(',', $item['categories']);
						$found_items = [];
						foreach($ids_categories as $cat){
							$search_items = array_search($cat, $categories->toArray());
							if($search_items){
								$found_items[] = $search_items;
							}
						}
						$var['categories'] = $found_items;
					}

					if(isset($item['brand'])){
						$search_brand = array_search($item['brand'], $brands->toArray());
						if($search_brand){
							$var['brand'] = $search_brand;
						}else{
							$var['brand'] = null;
						}
					}

					$data = \Storage::disk('shop')->url($item['id'] . '.jpg');
					if(isset($data) && $data){
						$var['image']    = $data;
					}

					$var['active']     = 1;
					$var['title']      = $item['title'] ?? $item['title_long'];
					$var['meta_title'] = $item['title'] ?? $item['title_long'];
					$var['price']      = $item['price'];
					$var['quantity']   = $item['quantity'];
					$var['min_opt']    = $item['min_opt'];
					$var['price_opt']  = $item['wholesale_price'];
					$var['sku']        = $item['sku'] . $item['id'];
					$var['slug']       = 1;
					$var['sort']       = 100;
					$variations[] = $var;
				}
				$product['selectedAttrVal'] = collect($selectedAttrVal);
				$product['variations'] = $variations;
			} else {
				if(isset($row[0]['categories'])){
					$ids_categories = explode(',', $row[0]['categories']);
					$found_items = [];
					foreach($ids_categories as $cat){
						$search_items = array_search($cat, $categories->toArray());
						if($search_items){
							$found_items[] = $search_items;
						}
					}
					$product['categories'] = $found_items;
				}

				if(isset($row[0]['brand'])){
					$search_brand = array_search($row[0]['brand'], $brands->toArray());
					if($search_brand){
						$product['brand'] = $search_brand;
					}else{
						$product['brand'] = null;
					}
				}

				$product['active']           = 1;
				$product['id']               = $row[0]['id'];
				$product['description']      = $row[0]['description'];
				$product['locale']           = 'ru';
				$product['price']            = $row[0]['price'];
				$product['quantity']         = $row[0]['quantity'];
				$product['sku']              = $row[0]['sku'] . $row[0]['id']  . 22;
				$product['sort']             = 100;
				$product['title']            = $row[0]['title'] ?? $row[0]['title_long'];
				$product['meta_title']       = $row[0]['title'] ?? $row[0]['title_long'];
				$product['meta_description'] = $row[0]['description'];
				$product['status_id']        = 1;

				if($row[0]['size']){
					$product['characteristic'] = 'Размер: ' . $row[0]['size'];
				}
				if($row[0]['title']){
					$product['slug'] = \Str::slug($row[0]['title']);
				}else{
					$product['slug'] = \Str::slug($row[0]['title_long']);
				}
//				\Storage::disk('shop')->get($row[0]['id'] . '.jpg');

				$data = \Storage::disk('shop')->url($row[0]['id'] . '.jpg');
				if(isset($data) && $data){
					$product['image'] = $data;
				}

			}

			$products[] = $product;
		}
//		dd($products);

// Check product if exist -> update/create product
		foreach($products as $product) {
			$model = Model::where('slug', '=', $product['slug'])->first();
//			if(isset($id)){
//				$model = Model::find($id)->first();
//			}
			if(isset($model) && $model) {
				$item = $this->repository->ImportUpdateProduct($model, $product);
			} else {
				$item = $this->repository->ImportCreateProduct($product);
			}
		}
		return $products;
	}

//Collection delimiter
	public function getCsvSettings(): array
	{
		return [
			'delimiter' => ";"
		];
	}

}
