<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    protected function sendResetResponse(Request $request, $response)
    {
        if ($request->wantsJson()) {
            $request->session()->flash('message', 'reseted');
            $request->session()->flash('message-type', 'success');

            return new JsonResponse(['message' => trans($response),
                'url'     => route('site.dashboard.profile')], 200);
        }

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
