<?php


namespace Customers\Api\Controllers;


use Admin\Services\Datatable;
use App\Http\Controllers\Controller;
use App\Mail\ResetMail;
use Customers\Api\Resources\CustomerTableResource;
use Customers\Models\Customer;
use Customers\Repositories\CustomersRepository;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(CustomersRepository::class);
    }

    public function index()
    {
        return response()->json(['data' => $this->repository->all(request()->all())]);
    }

    public function table()
    {
        $dt = new Datatable();
        $query = Customer::query();

        return CustomerTableResource::collection($dt->get($query));
    }

    public function show($id)
    {
        $customer = Customer::with(['addresses', 'orders','orders.payment_method','orders.status','delivery'])
            ->find($id);
        $total_price = $customer->orders()->sum('total_price');

        $customer->toArray();
        $customer['total_price'] = $total_price;



        return response()->json($customer);
    }

    public function store()
    {
        $customer = $this->repository->create(request()->all());

        return response()->json($customer->toArray());
    }

    public function update($id)
    {
        $customer = Customer::findOrFail($id);

        $customer = $this->repository->update($customer, request()->all());

        return response()->json($customer->toArray());
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        try {
            $customer->delete();
        } catch (\Exception $e) {
        }

        return response()->json('ok');
    }

    public function vuelidate(){
        $input = request()->all();
        if(isset($input['user_email'])){
            $customer = Customer::where('email',$input['user_email']);

            if(isset($input['id']) && is_numeric($input['id']))
                $customer = $customer->where('id','!=',$input['id']);

            return ['data'=>$customer->first()?false:true];
        }

        if(isset($input['user_phone'])){
            $customer = Customer::where('phone',$input['user_phone']);

            if(isset($input['id']) && is_numeric($input['id']))
                $customer = $customer->where('id','!=',$input['id']);

            return ['data'=>$customer->first()?false:true];
        }

        return ['data'=>false];

    }


    function updatePassword(Request $request){

        $customer = Customer::find($request->id);
        $customer->update(['password'=>bcrypt(uniqid('', true))]);

        \DB::table('password_resets')->insert([
            'email' => $customer->email,
            'token' => \Str::random(64),
            'created_at' => \Carbon\Carbon::now()
        ]);

        $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($customer);

        $link = env('APP_URL') . '/password/reset/' . $token . '?email=' . urlencode($customer->email);
        \Mail::to($customer->email)->send(new ResetMail($link));

        return ['success'];
    }
}
