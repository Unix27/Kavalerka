<?php
namespace Shop\Catalog\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Shop\Catalog\Api\Resources\AttributeTableResource;
use Shop\Catalog\Models\Attribute;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\ProductImage;

use Shop\Catalog\Models\VariationImage;
use Shop\Catalog\Models\Variations;
use Shop\Catalog\Repositories\AttributesRepository;
use Symfony\Component\VarDumper\Cloner\Data;

class VariationImagesController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(AttributesRepository::class);
    }

    public function index($id)
    {
        $arr = Variations::find($id)->images;
        $files = [];
        foreach ($arr as $key => $value) {
            $files[] = [
                'uid' => '-'.($key+1),
                'name' => uniqid().'.png',
                'status' => 'done',
                'url' => $value->url,
                'id' => $value->id
            ];
        }
        return  $files;
    }

    public function delete($id){
        VariationImage::find($id)->delete();
    }


}
