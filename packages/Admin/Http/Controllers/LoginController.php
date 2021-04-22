<?php


namespace Admin\Http\Controllers;

use Admin\Models\Admin;
use App\Http\Controllers\Controller;
use Auth;
use Customers\Models\Customer;
use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{

    protected $redirectTo = '/admin';

    public function __construct()
    {
        //$this->middleware('admin')->except('logout');
    }

    public function index()
    {
        return view('admin::user.login');
    }

    public function checkLogin(Request $request)
    {

        $this->validateLogin($request);

        if ($this->credentialsIsCorrect($request)) {

            $user = Customer::where('email', $request->get('login'))->first();

            //dd($user->google2fa_secret);

            if($user->google2fa_secret == null) {
                //dd(1);
                $this->attemptLogin($request);
                return $this->sendLoginResponse($request);
            }

            if (
                $user->google2fa_secret != null &&
                $request->get('2fa_answer') &&
                $request->get('2fa_answer') != null
            ) {
                $google2FA = new Google2FA();

                if($google2FA->verify(
                    $request->get('2fa_answer'),
                    $user->google2fa_secret
                )) {
                    $this->attemptLogin($request);
                    return $this->sendLoginResponse($request);
                } else {
                    return response()->json(['message' => 'Неверный код', 'csrf' => csrf_token()], 400);
                }
            }

            return response()->json(['message' => 'ok', 'csrf' => csrf_token()], 200);
        }

        //$this->incrementLoginAttempts($request);
        /*todo
        Попытки ввода пароля
        */

        return response()->json(['message' => 'Неверный логин или пароль', 'csrf' => csrf_token()], 400);
    }


    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function credentialsIsCorrect(Request $request)
    {
        $user = Customer::where('email', $request->get('login'))->first();


        $password = trim($request->get('password'));

        //dd($user->password, bcrypt($password));

        if($user) {
            if(password_verify($request->get('password'), $user->password))
                return true;
        }

        return false;
    }


    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }


    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }


    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        //$this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: response()->json(['redirect_url' => '/admin'], 200);
    }


    protected function authenticated(Request $request, $user)
    {
        //
    }


    public function username()
    {
        return 'login';
    }


    public function logout(Request $request)
    {
        $this->guard()->logout();


        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }


    protected function loggedOut(Request $request)
    {
        //
    }


    protected function guard()
    {
        return Auth::guard('admin');
    }
}
