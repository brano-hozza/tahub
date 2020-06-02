<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Storage;

/**
 * Class CloudController
 * @package App\Http\Controllers
 * @group Cloud
 */
class CloudController extends Controller
{
    /**
     * Ziskaj priecinky
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 200 - ok<br>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza default /
     */
    public function getFolders(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $dirs = Storage::disk('cloud')->directories(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($dirs); $i++) {
            $dirs[$i] = last(explode("/", $dirs[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "dirs" => $dirs
        ]);
    }

    /**
     * Ziskaj subory
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 200 - ok<br>
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza default /
     */
    public function getFiles(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $files = Storage::disk('cloud')->files(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = last(explode("/", $files[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "files" => $files
        ]);
    }

    /**
     * Vytvor priecinok
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - Nezadali ste meno<br>
     * 422 - nepodarilo sa vytvorit subor<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza.
     * @bodyParam name string required Nazov priecinka
     */
    public function addFolder(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $name = $request["name"];
        if ($name == null || $name == "") {
            return response()->json([
                "status_code" => 421
            ]);
        }
        if (!Storage::drive('cloud')->makeDirectory(hash("sha256", $user->email) . $path . '/' . $name)) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $dirs = Storage::disk('cloud')->directories(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($dirs); $i++) {
            $dirs[$i] = last(explode("/", $dirs[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "dirs" => $dirs
        ]);
    }

    /**
     * Odstran priecinok
     *
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - Nezadali ste meno<br>
     * 422 - nepodarilo sa vymazat subor<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza.
     * @bodyParam name string required Nazov priecinka
     */
    public function removeFolder(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $name = $request["name"];
        if ($name == null || $name == "") {
            return response()->json([
                "status_code" => 421
            ]);
        }
        if (!Storage::drive('cloud')->deleteDirectory(hash("sha256", $user->email) . $path . '/' . $name)) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $dirs = Storage::disk('cloud')->directories(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($dirs); $i++) {
            $dirs[$i] = last(explode("/", $dirs[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "dirs" => $dirs
        ]);
    }

    /**
     * Pridaj subor
     *
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - Nezadali ste meno<br>
     * 422 - nepodarilo sa vytvorit subor<br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza
     * @bodyParam subor file required Subor
     */
    public function addFile(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $file = $request->file('file');
        if (!$file) {
            return response()->json([
                "status_code" => 421
            ]);
        }
        if (!Storage::drive('cloud')->putFileAs(hash('sha256', $user->email) . $path, $file, $file->getClientOriginalName())) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $files = Storage::disk('cloud')->files(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = last(explode("/", $files[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "files" => $files
        ]);
    }

    /**
     * Zmaz subor
     *
     * Status kody: <br>
     * 420 - neplatny token <br>
     * 421 - Nezadali ste meno <br>
     * 422 - Nepodarilo sa vymazat subor <br>
     * 200 - ok
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza
     * @bodyParam subor file required Subor
     */
    public function removeFile(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $name = $request["name"];
        if ($name == null || $name == "") {
            return response()->json([
                "status_code" => 421
            ]);
        }
        if (!Storage::drive('cloud')->delete(hash('sha256', $user->email) . $path . '/' . $name)) {
            return response()->json([
                "status_code" => 422
            ]);
        }
        $files = Storage::disk('cloud')->files(hash("sha256", $user->email) . $path);
        for ($i = 0; $i < count($files); $i++) {
            $files[$i] = last(explode("/", $files[$i]));
        }
        return response()->json([
            "status_code" => 200,
            "files" => $files
        ]);
    }

    /**
     * Stiahni subor
     * Status kody:<br>
     * 420 - neplatny token<br>
     * 421 - Nezadali ste meno<br>
     * @param Request $request
     * @bodyParam api_token string required API token usera
     * @bodyParam path string optional Cesta kde sa nachadza
     * @bodyParam subor file required Subor
     * @return \Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function downloadFile(Request $request)
    {
        $user = User::where('api_token', hash("sha256", $request["api_token"]))->first();
        if (!$user) {
            return response()->json([
                "status" => "Neplatny token",
                "status_code" => 420
            ]);
        }
        $path = $request["path"];
        $name = $request["name"];
        if ($name == null || $name == "") {
            return response()->json([
                "status" => "Nezadali ste meno",
                "status_code" => 421
            ]);
        }
        return Storage::drive('cloud')->download(hash("sha256", $user->email) . $path . '/' . $name);
    }
}
