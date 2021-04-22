<?php


namespace Torgsoft\Http\Controllers;


use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Illuminate\Database\Eloquent\Relations\Relation;
use Ramsey\Uuid\Uuid;
use Shop\Catalog\Models\AttributeValue;
use Shop\Catalog\Models\Discounts;
use Shop\Catalog\Models\Product as Model;
use Shop\Catalog\Repositories\ProductsRepository as Repository;

use Maatwebsite\Excel\Facades\Excel;
use Torgsoft\Models\Import;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Shop\Catalog\Models\Product;
use Shop\Catalog\Models\ProductImage;
use Shop\Catalog\Models\Variations;
use Shop\Catalog\Models\Video;
use Shop\Catalog\Models\Relations;



class TorgsoftController extends Controller
{
	public function import()
	{
		$import = Excel::import(new	 Import, 'TSGoods.csv', 'public', \Maatwebsite\Excel\Excel::CSV);
		dd($import);
		return $import;
	}

}
