<?php


namespace Admin\Api\Controllers;


use Admin\Api\Resources\AdminPermissionsResource;
use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use Admin\Api\Resources\AdminRolesResource;
use Admin\Models\AdminPermission as Model;
use Admin\Repositories\AdminRolesRepository as Repository;
use Illuminate\Support\Facades\Auth;

class AdminMenuController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->repository = app(Repository::class);
//        $this->middleware('admin');
    }

    public function index()
    {


        $menu = auth()->user()->role->permissions()->with('children')->get();

        $newMenu = [];

        foreach($menu as $value){
            $newMenu[] = [
                'id' => $value['id'],
                'label' => $value['name'],
                'slug' => $value['slug']
            ];
            if(isset($value['children'])){
                foreach($value['children'] as $v){
                    $newMenu[] = [
                        'id' => $v['id'],
                        'label' => $v['name'],
                        'slug' => $v['slug']
                    ];


                    if(isset($v['children'])){
                        foreach ($v['children'] as $n){
                            $newMenu[] = [
                                'id' => $n['id'],
                                'label' => $n['name'],
                                'slug' => $n['slug']
                            ];

                        }
                    }
                }
            }


        }
        return $newMenu;

//        return auth()->user()->with('role','role.permissions')->first()->role->permissions;

       return [
           Auth::guard('api')->user(),
           Auth::guard('web')->user(),
            session()->all()
       ];
    }

}
