<?php


namespace Site\Common\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Blog\Models\BlogCategory;
use Blog\Models\BlogPost;
use Customers\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\HasApiTokens;
use Mail;
use Illuminate\Contracts\Auth\Authenticatable;
use Pages\Models\Page;
use samdark\sitemap\Sitemap;
use App\Mail\WelcomeMail;

class AuthController extends Controller
{
    use HasApiTokens, Notifiable;
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */

    protected $redirectTo = RouteServiceProvider::HOME;

    public function index()
    {
        dd(2);
        //return view('site::pages.home');
    }

    public function login(Request $request){

    	if(auth()->user()){
				return redirect('/');
			}

				$favorites = session()->get('favorites');

        if(request()->ajax()){
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
                    \Auth::login($user, true);

										if(isset($favorites)){
											$user->favorites()->sync($favorites);
											session()->flush('favorites');
										}

                    return [
                        'status' => 'success',
                        'url' => route('site.dashboard.profile')
                    ];
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



				$page = Page::where('slug', 'login')->first();

        return view('site::auth.login', compact( [ 'page', ] ));
    }

    public function register(){
			if(auth()->user()){
				return redirect('/');
			}
			$page = Page::where('slug', 'register')->first();

			return view('site::auth.register', compact( [ 'page', ] ));
    }

    public function registersend(Request $request){

			$this->validator($request->all())->validate();

			event(new Registered($customer = $this->create($request->all())));
			$this->guard()->login($customer);

			$request->session()->flash('message', 'registered');
			$request->session()->flash('message-type', 'success');

			$data = ([
				'email' => $customer->email,
				'first_name' => $customer->first_name,
			]);

			\Mail::to($data['email'])->send(new WelcomeMail($data));


			return new JsonResponse(['url' => route('success.register')], 200);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => ['required', 'regex:/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){12,16}(\s*)?$/', 'unique:customers'],
            'email' => ['required', 'string', 'regex:/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                        'max:255', 'unique:customers'],
            'password' => ['required', 'string', 'min:6'],
            'first_name' => ['required', 'string', 'not_regex:/[ˆ(\d|+|\-.,_<>!@#$%^&*~`)]/'],
            'confirmation' => ['required'],
        ]);
    }

    protected function create(array $data)
    {
        return Customer::create([
        		'first_name' => $data['first_name'],
            'phone'      => $data['phone'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);
    }

    public function logout(Request $request) {
        \Auth::logout();

        return redirect('/login');
    }

    public function successRegister() {
			$page = Page::where('slug', 'success-registration')->first();

    	return view('site::auth.success-authorization', compact( [ 'page' ]));
		}

    public function successSubscribed() {
			$page = Page::where('slug', 'successfully-subscribed')->first();

    	return view('site::successfully.successfully-subscribed', compact( [ 'page' ]));
		}

}
