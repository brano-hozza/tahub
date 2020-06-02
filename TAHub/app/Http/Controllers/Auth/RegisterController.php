<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\RegToken;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Storage;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 * @group Register
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required','string', 'max:255'],
            'last_name' => ['required','string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'api_token' => hash("sha256", Str::random(60))
        ]);
    }

    /**
     * Registracia
     * Funkcia registruje noveho uzivatela<br>
     * Status kody:<br>
     * 420 - uzivatel existuje<br>
     * 421 - neplatny token<br>
     * 422 - Chybaju data<br>
     * 450 - neviem vytvorit subor<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam first_name string required Meno
     * @bodyParam last_name string required Priezvisko
     * @bodyParam email string required E-mail
     * @bodyParam password string required Heslo
     */
    public function registerAPI(Request $request)
    {
        $user = User::where('email', $request["email"])->first();
        if ($user) {
            return \response()->json([
                "status_code" => 420
            ]);
        }
        $token = RegToken::where("token", hash("sha256", $request["token"]))->first();
        if (!$token) {
            return \response()->json([
                "status_code" => 421
            ]);
        }
        $token->used = true;
        $token->save();
        if (!$request["first_name"] || !$request["last_name"] || !$request["password"] || !$request["email"]){
            return \response()->json([
                "status_code" => 422
            ]);
        }
        $api_token_hash = Str::random(60);
        $api_token = $api_token_hash;
        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'api_token' => hash("sha256", $api_token_hash)
        ]);
        $user->api_token = $api_token;
        if (!Storage::disk('cloud')->makeDirectory(\hash('sha256',$user->email))){
            return \response()->json([
                "status_code" => 450
            ]);
        }

        return response()->json([
            "user" => $user,
            "status_code" => 200,
        ]);

    }

    /**
     * Generuj token
     * funkcia vygeneruje novy token na registraciu<br>
     * Status kody:<br>
     * 304 - Unauthorized<br>
     * 200 - ok<br>
     * @bodyParam api_token string Token admina
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createToken(Request $request)
    {
        $admin = User::where([
            ["api_token", hash("sha256", $request["api_token"])],
            ["admin", true]
        ])->first();
        if (!$admin) {
            return response()->json([
                "status_code" => 304
            ]);
        }
        $token = new RegToken();
        $new_token = Str::random(60);
        $nehash = $new_token;
        $token->token = \hash("sha256", $new_token);
        $token->save();
        return \response()->json([
            "token" => $nehash,
            "status" => "ok",
        ]);
    }

    /**
     * Generuj  v konzole
     * funkcia vygeneruje novy token na registraciu<br>
     * Status kody:<br>
     * 200 - ok<br>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function consoleToken(Request $request)
    {
        $token = new RegToken();
        $new_token = Str::random(60);
        $nehash = $new_token;
        $token->token = \hash("sha256", $new_token);
        $token->save();
        return \response()->json([
            "token" => $nehash,
            "status_code" => 200
        ]);
    }
}
