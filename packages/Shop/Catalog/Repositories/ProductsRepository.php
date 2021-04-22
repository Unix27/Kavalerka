<?php


namespace Shop\Catalog\Repositories;
use Image;
use ImageTool;
use Ramsey\Uuid\Uuid;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\AttributeValue;
use Shop\Catalog\Models\AttributeOption;

use Shop\Catalog\Models\Category;
use Shop\Catalog\Models\Discounts;
use Shop\Catalog\Models\FavoriteProduct;
use Shop\Catalog\Models\ViewedProduct;
use Shop\Catalog\Models\Product as Model;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Models\Relations;
use Shop\Catalog\Models\Variations;
use Shop\Catalog\Models\Video;
use Illuminate\Http\Request;
use Storage;


class ProductsRepository
{
    protected $locale;
    protected $imagesPath;

    public function __construct()
    {
        $this->locale = request()->input('locale') ?? app()->getLocale();
        $this->imagesPath = config('shop.catalog_images_path');
    }

    public function create(array $attributes)
    {

        if(!isset($attributes['price']) ){
            $attributes['price'] = 20;
        }

        if($attributes['title'] == ''){
            $attributes['title'] = 'Без имени';
        }

        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        if(empty($attributes['sku']))
            $attributes['sku'] = Uuid::uuid4();




        $model = Model::create($attributes);

				if($attributes['type'] == true){
					$model->type = 'retail';
				} else {
					$model->type = 'opt';
				}

        $attributes['id'] = $model->id;


//        collect($attributes['attributes'])->pluck('id')->toArray();

        $attrs = [];
        if(isset($attributes['attributes'])) {
            foreach ($attributes['attributes'] as $value) {
                if (!empty($value['value']['values'])) {
                    $attrs[$value['id']] = ['locale' => app()->getLocale()];
                }
            }
            $model->attributesGet()->wherePivot('locale', app()->getLocale())->sync($attrs);
        }

        $model->categories()->sync($attributes['categories']);
//
        $model->translateOrNew(app()->getLocale())->fill($attributes);


//        foreach ($attributes['attributes'] as $attribute) {
//            if(!empty($attribute['value'])) {
//                $attributeValue = new AttributeValue();
//                $attributeValue->product_id = $attributes['id'];
//                $attributeValue->attribute_id = $model->id;
//                $attributeValue->locale = app()->getLocale();
//                $attributeValue->value = $attribute['value'];
//                $attributeValue->save();
//            }
//        }

//        $this->saveAttributes($attributes);


        if(isset($attributes['fileList'])) {
            foreach ($attributes['fileList'] as $key => $file) {
                $image_64 = $file['fullSize']; //your base64 encoded data
                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = \Str::random(10) . '.' . $extension;
                \Storage::disk('shop')->put($imageName, base64_decode($image));
                $data = \Storage::disk('shop')->url($imageName);

                $image = new ProductImage();
                $image->product_id = $model->id;
                $image->sort = $key;
                $image->url = $data;

                $image->save();
            }
        }


			$attrs = [];
			$userVar = [];
			if(isset($attributes['selectedAttrVal']) && $attributes['selectedAttrVal']) {
				foreach ($attributes['selectedAttrVal'] as $value) {

					if(isset($value['use_var']) && $value['use_var']){
						$userVar[] = $value['attr_id'];
					}

					if(is_array($value['ids'])) {
						foreach ($value['ids'] as $v)
							$attrs[$v] = ['show'=>$value['show']];

					}
				}

				$model->attributesGet()->sync($attrs);

				if($userVar)
					$model->useVar()->sync($userVar);
			}

        if(isset($attributes['discounts'])){
            foreach($attributes['discounts'] as $value){
                if(isset($value['id'])){
                    $discount = Discounts::find($value['id']);
                }else{
                    $discount = new Discounts();
                }
                if(isset($value['group']['id'])){
                    $value['group_id'] = $value['group']['id'];
                }
                $value['price'] = str_replace('%','',$value['price']);
                $value['product_id'] = $model->id;

								if($value['type'] == true){
									$value['type'] = 'retail';
								} else {
									$value['type'] = 'opt';
								}

                $discount->fill($value);
                $discount->save();
            }
        }

        $attributes['id'] = $model->id;
//        $this->saveProductRelations('recomended',$attributes);
//        $this->saveProductRelations('buy_with',$attributes);
        $this->saveProductRelations('similiar',$attributes);

        if(isset($attributes['videos'])) {
            foreach ($attributes['videos'] as $value) {
                if(isset($value['id'])){
                    $video = Video::find($value['id']);
                }else{
                    $video = new Video();
                }
                $video->product_id = $model->id;
                $video->link = $value['link'];

                $video->save();
            }
        }

        $model->save();

        return $model;
    }

    public function update(Model $model, array $attributes)
    {


        if(empty($attributes['slug']))
            $attributes['slug'] = \Str::slug($attributes['title']);

        if(empty($attributes['sku']))
            $attributes['sku'] = Uuid::uuid4();

        $model->fill($attributes);

        $model->save();

        $attributes['id'] = $model->id;

        $attrs = [];
        $userVar = [];
        if(isset($attributes['selectedAttrVal']) && $attributes['selectedAttrVal']) {
            foreach ($attributes['selectedAttrVal'] as $value) {

                if($value['use_var']){
                    $userVar[] = $value['attr_id'];
                }

                if(is_array($value['ids'])) {
                    foreach ($value['ids'] as $v)
                        $attrs[$v] = ['show'=>$value['show']];

                }
            }

            $model->attributesGet()->sync($attrs);
            file_put_contents('last.log', json_encode($attrs));
            $model->useVar()->sync($userVar);
        }


//        $this->saveAttributes($attributes);

        $model->categories()->sync($attributes['categories']);



        if(isset($attributes['removeAttr'])) {
            foreach ($attributes['removeAttr'] as $value) {
                AttributeValue::find($value)->delete();
            }
        }



        $ids = [];
        if(isset($attributes['discounts'])){
            foreach($attributes['discounts'] as $value){
                if(isset($value['id'])){
                    $ids[] = $value['id'];
                    $discount = Discounts::find($value['id']);
                }else{
                    $discount = new Discounts();
                }
                if(isset($value['group']['id'])){
                    $value['group_id'] = $value['group']['id'];
                }
                $value['price'] = str_replace('%','',$value['price']);
                $value['product_id'] = $model->id;

								if($value['type'] == true){
									$value['type'] = 'retail';
								} else {
									$value['type'] = 'opt';
								}

                $discount->fill($value);
                $discount->save();

                $ids[] = $discount->id;

            }
        }
        if($ids){
            Discounts::whereNotIn('id',$ids)->where('product_id',$attributes['id'])->delete();
        }

        if(isset($attributes['fileList'])) {
            foreach ($attributes['fileList'] as $key => $file) {
                if(isset($file['fullSize'])) {
                    $image_64 = $file['fullSize']; //your base64 encoded data
                    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
                    $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                    $image = str_replace($replace, '', $image_64);
                    $image = str_replace(' ', '+', $image);
                    $imageName = \Str::random(10) . '.' . $extension;
                    \Storage::disk('shop')->put($imageName, base64_decode($image));
                    $data = \Storage::disk('shop')->url($imageName);

//                    $imageName = \Str::random(10) . '.' . $file['name'];
//                    \Storage::disk('shop')->put($imageName, base64_decode($file['response']));
//                    $data = \Storage::disk('shop')->url($imageName);

                    $image = new ProductImage();
                    $image->product_id = $model->id;
                    $image->sort = $key;
                    $image->url = $data;

                    $image->save();
                }
            }
        }


        if(isset($attributes['videos'])) {
            foreach ($attributes['videos'] as $value) {
                if(isset($value['id'])){
                    $video = Video::find($value['id']);
                }else{
                    $video = new Video();
                }
                $video->product_id = $attributes['id'];
                $video->link = $value['link'];
                $video->save();
            }
        }

//        $this->saveProductRelations('recomended',$attributes);
//        $this->saveProductRelations('buy_with',$attributes);
        $this->saveProductRelations('similiar',$attributes);

        $this->saveProductVaritaions($attributes);

        $model->translateOrNew(app()->getLocale())->fill($attributes);

        $model->save();


        if(isset($attributes['removeVariations'])){
            Variations::whereIn('id',$attributes['removeVariations'])->delete();
        }


        return $model;
    }

    public function saveAttributes($attributes){
        $ids = [];
        foreach ($attributes['attributes'] as $attribute) {
            if(!empty($attribute['value'])) {
                foreach ($attribute['value']['values'] as $key => $v) {
                    if(!in_array($v, $attribute['value']['id'])){
                        $attributeValue = new AttributeValue();
                        $attributeValue->product_id = $attributes['id'];
                        $attributeValue->attribute_id = $attribute['id'];
                        $attributeValue->locale = app()->getLocale();
                        $attributeValue->value = $v;
                        $attributeValue->save();
                        $ids[] = $attributeValue->id;
                    }else{
                        $ids[] = key($attribute['value']['id']);
                    }
                }

            }

        }
        file_put_contents('test.log',json_encode($ids));
        AttributeValue::whereNotIn('id',$ids)
            ->where('locale',app()->getLocale())
            ->where('product_id',$attributes['id'])->delete();
    }

    public function saveProductRelations($type,$attributes){
        if(isset($attributes[$type])){
            foreach($attributes[$type] as $value){
                if(isset($value['table_id'])){
                    $relations = Relations::find($value['table_id']);
                }else{
                    $relations = new Relations();
                }

                $relations->current_product_id = $attributes['id'];
                $relations->product_id = $value['id'];
                $relations->type = $type;
                $relations->save();
            }
        }
    }

    public function saveProductVaritaions($attributes){
			if(isset($attributes['variations'])){
				foreach($attributes['variations'] as $variation){
                if(isset($variation['id'])){
                    $var = Variations::find($variation['id']);
                }else{
                	$var = Variations::whereTranslationLike('title', $variation['title'])
										->where('sku', '=', $variation['sku'])->first();
                	if(!$var) {
										$var = new Variations();
									}
                }
                $variation['product_id'] = $attributes['id'];
                $variation['attribute_id'] = null;

//                $variation['locale'] =  app()->getLocale();

                $var->fill($variation);
                $var->save();
                $tags = [];
                if(isset($variation['attr'])) {
                    foreach ($variation['attr'] as $tag) {
                        if(isset($tag['id'])) {
                            $tags[] = ['value_id' => $tag['id']];
                        }
                    }
                    file_put_contents('last.log', json_encode($tags));
                    $var->values()->sync($tags);
								}
            }
        }
    }

		public function removeFromFavorite(){

			$input = \Request::all();

			if($input['product_id'] == 'all'){
				$favorite_products = FavoriteProduct::where('customer_id', '=', auth()->user()->id)->delete();

				return response()->json('all', 200);
			} else {
				$favorite_product = FavoriteProduct::where('product_id', '=', $input['product_id'])
					->where('customer_id', '=', auth()->user()->id)->first();

				$favorite_product->delete();
			}

			return response()->json('success', 200);
		}

		public function addToFavorite(\Request $request){

    	$input = \Request::all();

    	if(auth()->user()){
				if($input['product_id'] == 'all'){
					$viewed_products = ViewedProduct::where('customer_id', '=', auth()->user()->id)->delete();

					return response()->json('all', 200);
				} else {

					$favorite_products = FavoriteProduct::where('product_id', '=', $input['product_id'])
						->where('customer_id', '=', auth()->user()->id)->first();

					if(isset($favorite_products)){

						$favorite_products->delete();

						return response()->json('delete', 200);

					} else {

						$favorite_products = new FavoriteProduct();

						$favorite_products->product_id = $input['product_id'];
						$favorite_products->customer_id = auth()->user()->id;

						$favorite_products->save();
					}
				}
			} else {
				$in_session = false;
				if(session()->get('favorites')){
					$in_session = array_search($input['product_id'], session()->get('favorites'));
					if($in_session !== false){
						$favorites = session()->get('favorites');
						unset($favorites[intval($in_session)]);

//						return response()->json([
//							'session' => session()->get('favorites'),
//							'in_sess_pos' => session()->get('favorites')[$in_session],
//							'in_session' => $in_session,
//						]);

						return response()->json('delete', 200);
					} else {
						session()->push('favorites', $input['product_id']);
					}
				} else{
					session()->push('favorites', $input['product_id']);
				}
			}



			return response()->json('success', 200);
		}

		public function ImportCreateProduct(array $attributes)
		{

			if(!isset($attributes['price']) ){
				$attributes['price'] = 20;
			}

			if($attributes['title'] == ''){
				$attributes['title'] = 'Без имени';
			}

			if(empty($attributes['slug'])){
				$attributes['slug'] = \Str::slug($attributes['title']);
			}

			if(empty($attributes['sku'])){
				$attributes['sku'] = Uuid::uuid4();
			}

			$model = Model::create($attributes);
			$attributes['id'] = $model->id;

			$attrs = [];
			if(isset($attributes['attributes'])) {
				foreach ($attributes['attributes'] as $value) {
					if (!empty($value['value']['values'])) {
						$attrs[$value['id']] = ['locale' => app()->getLocale()];
					}
				}
				$model->attributesGet()->wherePivot('locale', app()->getLocale())->sync($attrs);
			}

			$model->categories()->sync($attributes['categories']);

			$model->translateOrNew(app()->getLocale())->fill($attributes);

			if(isset($attributes['fileList'])) {
				foreach ($attributes['fileList'] as $key => $file) {
					$image_64 = $file['fullSize']; //your base64 encoded data
					$extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
					$replace = substr($image_64, 0, strpos($image_64, ',') + 1);
					$image = str_replace($replace, '', $image_64);
					$image = str_replace(' ', '+', $image);
					$imageName = \Str::random(10) . '.' . $extension;
					\Storage::disk('shop')->put($imageName, base64_decode($image));
					$data = \Storage::disk('shop')->url($imageName);

					$image = new ProductImage();
					$image->product_id = $model->id;
					$image->sort = $key;
					$image->url = $data;

					$image->save();
				}
			}

			$attrs = [];
			$userVar = [];

			if(isset($attributes['selectedAttrVal']) && $attributes['selectedAttrVal']) {
				foreach ($attributes['selectedAttrVal'] as $value) {

					if(isset($value['use_var']) && $value['use_var']){
						$userVar[] = $value['attr_id'];
					}

					if(is_array($value['ids'])) {
						foreach ($value['ids'] as $v)
							$attrs[$v] = ['show'=>$value['show']];

					}
				}

				$model->attributesGet()->sync($attrs);

				if($userVar)
					$model->useVar()->sync($userVar);
			}

			if(isset($attributes['discounts'])){
				foreach($attributes['discounts'] as $value){
					if(isset($value['id'])){
						$discount = Discounts::find($value['id']);
					}else{
						$discount = new Discounts();
					}
					if(isset($value['group']['id'])){
						$value['group_id'] = $value['group']['id'];
					}
					$value['price'] = str_replace('%','',$value['price']);
					$value['product_id'] = $model->id;
					$discount->fill($value);
					$discount->save();
				}
			}

			$attributes['id'] = $model->id;
			$this->saveProductRelations('similiar',$attributes);

			if(isset($attributes['videos'])) {
				foreach ($attributes['videos'] as $value) {
					if(isset($value['id'])){
						$video = Video::find($value['id']);
					}else{
						$video = new Video();
					}
					$video->product_id = $model->id;
					$video->link = $value['link'];

					$video->save();
				}
			}

			$this->saveProductVaritaionsImport($attributes);
			$model->translateOrNew(app()->getLocale())->fill($attributes);
			$model->save();

			if(isset($attributes['removeVariations'])){
				Variations::whereIn('id',$attributes['removeVariations'])->delete();
			}

			return $model;
		}

		public function ImportUpdateProduct(Model $model, array $attributes)
		{
		if(empty($attributes['slug']))
			$attributes['slug'] = \Str::slug($attributes['title']);

		if(empty($attributes['sku']))
			$attributes['sku'] = Uuid::uuid4();

		$model->fill($attributes);
		$model->save();

		$attributes['id'] = $model->id;

		$attrs = [];
		$userVar = [];
		if(isset($attributes['selectedAttrVal']) && $attributes['selectedAttrVal']) {
			foreach ($attributes['selectedAttrVal'] as $value) {

				if($value['use_var']){
					$userVar[] = $value['attr_id'];
				}

				if(is_array($value['ids'])) {
					foreach ($value['ids'] as $v)
						$attrs[$v] = ['show'=>$value['show']];
				}
			}

			$model->attributesGet()->sync($attrs);
			file_put_contents('last.log', json_encode($attrs));
			$model->useVar()->sync($userVar);
		}

		$model->categories()->sync($attributes['categories']);

		if(isset($attributes['removeAttr'])) {
			foreach ($attributes['removeAttr'] as $value) {
				AttributeValue::find($value)->delete();
			}
		}

		$ids = [];
		if(isset($attributes['discounts'])){
			foreach($attributes['discounts'] as $value){
				if(isset($value['id'])){
					$ids[] = $value['id'];
					$discount = Discounts::find($value['id']);
				}else{
					$discount = new Discounts();
				}
				if(isset($value['group']['id'])){
					$value['group_id'] = $value['group']['id'];
				}
				$value['price'] = str_replace('%','',$value['price']);
				$value['product_id'] = $model->id;
				$discount->fill($value);
				$discount->save();

				$ids[] = $discount->id;
			}
		}

		if($ids){
			Discounts::whereNotIn('id',$ids)->where('product_id',$attributes['id'])->delete();
		}

		if(isset($attributes['fileList'])) {
			foreach ($attributes['fileList'] as $key => $file) {
				if(isset($file['fullSize'])) {
					$image_64 = $file['fullSize']; //your base64 encoded data
					$extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
					$replace = substr($image_64, 0, strpos($image_64, ',') + 1);
					$image = str_replace($replace, '', $image_64);
					$image = str_replace(' ', '+', $image);
					$imageName = \Str::random(10) . '.' . $extension;
					\Storage::disk('shop')->put($imageName, base64_decode($image));
					$data = \Storage::disk('shop')->url($imageName);

					$image = new ProductImage();
					$image->product_id = $model->id;
					$image->sort = $key;
					$image->url = $data;

					$image->save();
				}
			}
		}

		if(isset($attributes['videos'])) {
			foreach ($attributes['videos'] as $value) {
				if(isset($value['id'])){
					$video = Video::find($value['id']);
				}else{
					$video = new Video();
				}
				$video->product_id = $attributes['id'];
				$video->link = $value['link'];
				$video->save();
			}
		}

		$this->saveProductRelations('similiar',$attributes);
		$this->saveProductVaritaionsImport($attributes);
		$model->translateOrNew(app()->getLocale())->fill($attributes);
		$model->save();

		if(isset($attributes['removeVariations'])){
			Variations::whereIn('id',$attributes['removeVariations'])->delete();
		}

		return $model;
	}

		public function saveProductVaritaionsImport($attributes){
			if(isset($attributes['variations'])){
				foreach($attributes['variations'] as $variation){
					if(isset($variation['id'])){
						$var = Variations::find($variation['id']);
					}else{
						$var = Variations::whereTranslationLike('title', $variation['title'])
							->where('sku', '=', $variation['sku'])->first();
						if(!$var) {
							$var = new Variations();
						}
					}
					$variation['product_id'] = $attributes['id'];
					$variation['attribute_id'] = null;

	//                $variation['locale'] =  app()->getLocale();

					$var->fill($variation);
					$var->save();
					$locales = ['ru', 'en'];
					foreach($locales as $locale){
						$var->translateOrNew($locale)->fill($variation);
					}

					$var->save();
					$tags = [];
					if(isset($variation['attr'])) {
						foreach ($variation['attr'] as $tag) {
							if(isset($tag['id'])) {
								$tags[] = ['value_id' => $tag['id']];
							}
						}
						file_put_contents('last.log', json_encode($tags));
						$var->values()->sync($tags);
					}
				}
			}
		}

}
