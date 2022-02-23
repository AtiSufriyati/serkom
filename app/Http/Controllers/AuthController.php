<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\MasterUser;

use Response;


class AuthController extends Controller
{
    protected $model;
    protected $request;
    public function __construct(){
        $this->request = request();
        $this->model                    = new MasterUser();
    }

    #region Login
    public function login(){
        try{
            return view('auth.login');
        }catch(Exception $e){
            throw $e;
        }
    }
    public function dologin(){
        try{
            $email = $this->request->email;
            $password = $this->request->password;
            $check = MasterUser::where([['Email',$email],['Password',$password]])->exists();
            if($check){
                $data = [
                    'respon' => 'success',
                    'flag' => 'loged',
                    'message' => 'You are successfully login',
                    'url' => route('home')
                ];
            }else{
                $data = [
                    'respon' => 'failed',
                    'flag' => 'failed',
                    'message' => 'Email or Password is invalid',
                ];
            }
            
            return response()->json($data, 200);
        }catch(Exception $e){
            throw $e;
        }
    }
}
