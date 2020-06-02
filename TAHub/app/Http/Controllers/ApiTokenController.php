<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Class ApiTokenController
 * @package App\Http\Controllers
 * @group API token
 */
class ApiTokenController extends Controller
{
    /**
     * Renew tokena
     * Funkcia obnovi token a vrati novy token <br>
     * Status kody: <br>
     * 420 - neplatny token <br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     */
    public function update(Request $request)
    {
        $user = User::where("api_token", hash('sha256', $request["api_token"]))->first();
        if ($user == null) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $token = Str::random(60);
        $user->forceFill([
            'api_token' => hash('sha256', $token)
        ])->save();
        return response()->json([
            "token" => $token,
            "status_code" => 200,
        ]);
    }
}
