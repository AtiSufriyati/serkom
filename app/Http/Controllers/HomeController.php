<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        try{
            $this->data['route_url'] = \Request::route()->getName();
            return view('pages.home.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }
}
