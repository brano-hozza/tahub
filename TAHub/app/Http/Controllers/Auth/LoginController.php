<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 * @group Login
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        return (1);
    }


    /**
     * Prihlasenie
     * Funkcia prihlasi uzivatela vrati mu info<br>
     * Status kody:<br>
     * 402 - zle udaje<br>
     * 200 - ok<br>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam email string required Prihlasovaci email
     * @bodyParam password string required Heslo uzivatela
     */
    public function loginAPI(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = Str::random(60);
            $unhash_token = $token;
            $user->forceFill([
                'api_token' => hash('sha256', $token)
            ])->save();
            $user->api_token = $unhash_token;
            return response()->json([
                "status_code"=>200,
                "user" => $user,
            ]);
        } else {
            return response()->json([
                "status_code"=>402,
            ]);
        }
    }
}
