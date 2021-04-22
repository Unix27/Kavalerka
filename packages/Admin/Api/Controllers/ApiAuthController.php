<?php


namespace Admin\Api\Controllers;


use Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Customers\Models\Customer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
class ApiAuthController extends Authenticatable
{

//    use AuthenticatesUsers;
    use HasApiTokens, Notifiable;

    public function __construct()
    {
//        $this->middleware(['auth']);
    }

    public function login (Request $request) {

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = Customer::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client');


                $menu = $user->role->permissions()->with('children')->get();

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



                $response = ['user' => $token, 'permissions' => $newMenu,
                    'status' => 'success'];
                return response($response, 200);
            } else {
                $response = [
                    "message" => 'Неверный пароль',
                    "status" => 'error',
                ];
                return response($response, 422);
            }
        } else {
            $response = [
                "message" =>'Пользователь не найден',
                "status" => 'error',
            ];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

}
