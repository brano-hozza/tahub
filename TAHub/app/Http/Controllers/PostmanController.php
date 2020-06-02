<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostmanController extends Controller
{
    /**
     * CSRF
     * Vrati CSRF token
     * @group Postman
     * @param Request $request
     * @return string CSRF token
     */
    public function index(){
        return(csrf_token());
    }
}
