<?php

namespace Shop\Catalog\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package Shop\Catalog\Models
 * @mixin \Eloquent
 */

class Category extends Model
{
    use Translatable;

    protected $table = 'shop_categories';

    public $searchable = ['title', 'description'];

    public $translatedAttributes = ['title', 'description', 'seo_text',
        'meta_title', 'meta_description', 'meta_keywords'];

    public $translationModel = CategoryTranslation::class;

    protected $fillable = ['status_id', 'show_menu','slug', 'main_category_id', 'show_on_front', 'show_catalog', 'sort_menu', 'sort_catalog', 'parent_id', 'image'];

    public function parent()
    {
        return $this->hasOne(Category::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id')->with('children');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'shop_products_shop_categories');
    }

		public function getParentsAttribute()
		{
			$parents = collect([]);

			$parent = $this->parent;

			while(!is_null($parent)) {

				$parents->push($parent);
				$parent = $parent->parent;
			}

			return $parents->reverse();
		}

		public function getShowOnFrontCategories($categories,$ids){

			foreach($categories as $key => $category) {
					$ids->push($category);
					$category = $category->children()->where('show_on_front','=',1)->get();
					$this->getShowOnFrontCategories($category,$ids);
			}

			return $ids;
		}

		public function getSubCategories($categories,$ids){

			foreach($categories as $key => $category) {
					$ids->push($category);
					$category = $category->children()->where('status_id','=',1)->get();
					$this->getSubCategories($category,$ids);
			}

			return $ids;
		}

		public function getTopMenu(){
			$main_category = \Shop\Catalog\Models\Category::where('id', '=', session()->get('category'))->first();

			if(!isset($main_category)){
				$main_category = \Shop\Catalog\Models\Category::where([
					['status_id', '=', 1],
					['show_menu', '=', 1],
					['parent_id', '=', null],
				])->first();
			}

			$categories = \Shop\Catalog\Models\Category::where([
				['status_id', '=', 1],
				['show_menu', '=', 1],
				['parent_id', '=', null],
			])->orderBy('sort_menu')->get();

			$sort = [];

			$i = 0;
			foreach($categories as $category) {

				$sort[$category->id]['cur'] = [
					'title' => $category->title,
					'image' => $category->image,
					'id' => $category->id,
					'slug' => $category->slug
				];
			}

			return [
				'sort_categories' => $sort,
				'category' => $main_category->id,
				'categories' => $categories
			];
		}

		public function getMenuCatalog(){
    	$main_category = \Shop\Catalog\Models\Category::where('id', '=', session()->get('category'))->first();
    	if(!isset($main_category)){
				$main_category = \Shop\Catalog\Models\Category::where([
					['status_id', '=', 1],
					['show_menu', '=', 1],
					['parent_id', '=', null],
				])->first();
			}

			$categories = \Shop\Catalog\Models\Category::where([
				['status_id', '=', 1],
				['show_menu', '=', 1],
				['parent_id', '=', $main_category->id]
			])->with('children')->orderBy('sort_menu')->get();

			$sort = [];

			$i = 0;

			foreach($categories as $category) {

				$sort[$category->id]['cur'] = [
					'title' => $category->title,
					'id' => $category->id,
					'slug' => $category->slug
				];

				$children_categories = $category->children()->where([
					['status_id', '=', 1],
					['show_menu', '=', 1],
				])->get();

				foreach($children_categories as $key => $child){

					$child_categories = $child->children()->where([
						['status_id','=', 1],
						['show_menu', '=', 1],
					])->get();
					foreach($child_categories as  $ch){
						if($key % 3 == 0 && $key != 0){
							$i++;
	//                        $sort[$category->id][$child->id][$i] = $ch;
							$sort[$category->id]['child'][$i][$child->id]['child'][] = [
								'title' => $ch->title,
								'id' => $ch->id,
								'slug' => $ch->slug
							];
						}else{
							$sort[$category->id]['child'][$i][$child->id]['child'][] = [
								'title' => $ch->title,
								'id' => $ch->id,
								'slug' => $ch->slug
							];
						}
						$sort[$category->id]['child'][$i][$child->id]['cur']['title'] = $child->title;
						$sort[$category->id]['child'][$i][$child->id]['cur']['id'] = $child->id;
						$sort[$category->id]['child'][$i][$child->id]['cur']['slug'] = $child->slug;
					}
				}
			}


			return [
				'sort_categories' => $sort,
				'categories' => $categories,
				'category' => $main_category,
			];
		}


}
