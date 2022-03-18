<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Session;
use App\Models\MasterUser;

class MyAuth
{

    public static function Attempt($email,$authority = null){
      
        $User = MasterUser::where('Email',$email)
        $token = Session::get('_token');
        Session::flush();

        // memulai aktifkan session
        Session::put('_token',$token);
        Session::put('USER_SESSION',TRUE);

        Session::put('USER_INDEX', \Hashids::encode($User->IndexUser));
        Session::put('USER_ID', $User->UserID);
        Session::put('USER_NAME',$User->UserName);
        Session::put('USER_EMAIL',$User->Email);
        Session::put('USER_PHONE',$User->Phone);
        Session::put('USER_ADMIN_NAME',$User->AdminName);
        Session::put('USER_INDEX_LEVEL',$User->IndexLevel);

        Session::put('DisplayMenu','hide');
    }


    public static function Auth_isLogin()
    {
        if(Session::has('USER_SESSION')*1==1)
        {
            return TRUE;
        }
    }


}
?>