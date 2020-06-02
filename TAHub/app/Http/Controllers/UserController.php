<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Info o userovi
     * Funkcia ziska usera<br>
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 200 - ok<br>
     * @group User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     */
    public function getUser(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request['api_token']))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420,
            ]);
        }
        return response()->json([
            "status_code"=>200,
            "user" => $user
        ]);
    }

}
