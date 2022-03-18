<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;

class HomeController extends Controller
{
    public function index(){
        try{
            $this->data['route_url'] = \Request::route()->getName();    
            // dd(Session::get('UserName'));

            return view('pages.home.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }
}
