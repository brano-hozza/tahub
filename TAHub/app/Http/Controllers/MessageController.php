<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class MessageController
 * @package App\Http\Controllers
 * @group Message
 * @authenticated
 */
class MessageController extends Controller
{
    /**
     * Odoslanie spravy
     * Funkcia vytvori spravu a odosle<br>
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - prijmatel neexistuje<br>
     * 422 - prazdna sprava<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     * @bodyParam id int required ID prijmatela
     * @bodyParam message string required Sprava
     */
    public function create(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request['api_token']))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $recipient = User::find($request["id"]);
        if (!$recipient) {
            return response()->json([
                "status_code" => 421
            ]);
        }
        $data = $request["message"];
        if (!$data) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $mess = new Message();
        $mess->sender()->associate($user);
        $mess->recipient()->associate($recipient);
        $mess->message = $data;
        $mess->save();
        return response()->json([
            "status_code" => 200,
            "message" => $mess
        ]);
    }
    /**
     * Ziskat spravy
     * Funkcia ziska spravy s priatelom<br>
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - prijmatel neexistuje<br>
     * 422 - neplatny pocet sprav<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     * @bodyParam id int required ID prijmatela
     * @bodyParam amount number required Mnozstvo sprav
     */
    public function getMessages(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request['api_token']))->first();
        //return response()->json($user);
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $recepient = User::find($request["id"]);
        if (!$recepient) {
            return response()->json([
                "status_code" => 421
            ]);
        }
        $amount = $request["amount"];
        if (!$amount) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $messe = DB::table('messenger')
            ->where([
                ['receiver_id', $user->id],
                ['sender_id', $recepient->id]
            ])
            ->orWhere([
                ['receiver_id', $recepient->id],
                ['sender_id', $user->id]
            ])
            ->orderBy('id', 'desc')
            ->take($amount)
            ->get();
        return response()->json([
            "status_code" => 200,
            "messenger" => $messe
        ]);
    }

    /**
     * Pridat priatela
     * Funkcia prida priatela<br>
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - priatel neexistuje<br>
     * 200 - ok<br>
     * @group Friends
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     * @bodyParam id int required ID priatela
     */
    public function addFriend(Request $request){
        $user = User::where('api_token', hash("sha256", $request['api_token']))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $friend = User::where("email", $request["email"])->first();
        if (!$friend) {
            return response()->json([
                "status_code" => 421
            ]);
        }
        $user->friends()->attach($friend);
        $user->save();
        return response()->json([
            "status_code" => 200
        ]);

    }
    /**
     * Zobraz priatelov
     * Funkcia ziska priatelov<br>
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 200 - ok
     * @group Friends
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API Token usera
     */
    public function getFriends(Request $request){
        $user = User::where('api_token', hash("sha256", $request['api_token']))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        return response()->json([
            "status_code" => 200,
            "friends"=>$user->friends
        ]);
    }
}
