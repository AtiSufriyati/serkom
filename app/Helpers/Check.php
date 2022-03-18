<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use App\Models\HRM\Employee as HrmEmployee;
use App\Models\Kenji\Employee\EmployeeMultiDivisi;
use App\Models\Employee;
use App\Models\General;
use Session;
use Route;
use Redirect;
use Illuminate\Support\Facades\Hash;

class Check
{
    protected $except = false;
    protected $query;
    protected $auth;
    protected $request;
    protected $class;

    public function __construct(){
        $this->HrmEmployee = new HrmEmployee();
        $this->Employee = new Employee();
        $this->General = new General();
    }

    public function auth($request)
    {
        try{
            $this->request = $request;
            $UserAuthority = Session::get('USER_AUTHORITY');
            $UrlFirstSegment = \Request::segment(1);
            if($UrlFirstSegment != 'api')
            {
                if($UserAuthority == 'DEVELOPER')
                {
                    $this->query = DB::table('Master_BackEndMenu')
                        ->join('Master_AuthorityMenu','Master_BackEndMenu.IndexBackEndMenu','=','Master_AuthorityMenu.IndexBackEndMenu')
                        ->where('Status','ACTIVE');
                }
                else
                {
                    $this->query = DB::table('Master_BackEndMenu')
                        ->join('Master_AuthorityMenu','Master_BackEndMenu.IndexBackEndMenu','=','Master_AuthorityMenu.IndexBackEndMenu')
                        ->where([['Master_AuthorityMenu.AuthorityName', $UserAuthority],['Master_BackEndMenu.MenuUrl',$UrlFirstSegment],['Status','ACTIVE']]);
                }
            }
            return $this;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function except($except)
    {
        try{
            $UrlFirstSegment = \Request::segment(1);
            if($UrlFirstSegment != 'api')
            {
                if(is_array($except) || is_object($except)){
                    if(in_array(explode('@', Route::getCurrentRoute()->getActionName())[1] ,(array) $except)){
                        $this->except = true;
                    }
                }
                else{
                    if(explode('@', Route::getCurrentRoute()->getActionName())[1] == $except){
                        $this->except = true;
                    } 
                }

                if(strpos(strtolower(explode('@', Route::getCurrentRoute()->getActionName())[1]),'get') !== false){
                    $this->except = true;
                }
            }
            else
            {
                $this->except = true;
            }
            // if(request()->ajax()){
            //     $this->except = true;
            // }
            return $this;
        }
        catch(Exception $e){
            throw $e;
        }
    }

    public function authSession()
    {
        $hasil = false;

        $UrlFirstSegment = \Request::segment(1);
        if($UrlFirstSegment != 'api')
        {
            if(\Session::has('USER_INDEX')) {
                $IndexEmployee = \General::HashId(\Session::get('USER_INDEX'),'decode');

                $employee = Employee::where('IndexEmployee',$IndexEmployee)
                                        ->where('Active',1);

                if($employee->exists()){

                    $employee = $employee->first();

                    /*** coding validasi dari febri sebelum di rubah ***/
                    // if(strtoupper($employee->EmployeeID) == strtoupper(\Session::get('USER_ID')) 
                    //     && strtoupper($employee->CompanyID) == strtoupper(\Session::get('USER_COMPANY_ID'))
                    //     && strtoupper($employee->DivisiID) == strtoupper(\Session::get('USER_DIVISI_ID'))
                    //     && strtoupper($employee->BackendAuthority) == strtoupper(\Session::get('USER_AUTHORITY'))){
                    //         $hasil = true;
                    // }
                    /*** coding validasi dari febri sebelum di rubah ***/

                    // dd('Session : '.\Session::get('USER_DIVISI_ID'). ' **** DivisiID : '. $employee->DivisiID);
                    // if(strtoupper(\Session::get('USER_AUTHORITY')) == 'DEVELOPER') // ini digunakan buat handle switch employee
                    // {
                    //     $hasil = true;
                    // }
                    // else
                    // {
                        if(strtoupper($employee->EmployeeID) == strtoupper(\Session::get('USER_ID')) 
                            // && strtoupper($employee->CompanyID) == strtoupper(\Session::get('USER_COMPANY_ID'))
                            && strtoupper($employee->BackendAuthority) == strtoupper(\Session::get('USER_AUTHORITY'))) // ini untuk check apakah ada perubahan data EmployeeID, CompanyID, Authority
                        {
                                if(strtoupper($employee->DivisiID) == strtoupper(\Session::get('USER_DIVISI_ID'))) // ini untuk check apakah ada perubahan data divisi
                                {
                                    $hasil = true;
                                }
                                else
                                {
                                    if(EmployeeMultiDivisi::where([['EmployeeID', strtoupper(\Session::get('USER_ID'))], ['DivisiID', strtoupper(\Session::get('USER_DIVISI_ID'))]])->exists()) // ini untuk nge check kalau memang ada list multidivisi maka boleh
                                    {
                                        $hasil = true;
                                    }
                                }
                        }
                        // if($hasil)
                        // {
                        //     if(strtoupper($employee->BackendAuthority) == strtoupper(\Session::get('USER_AUTHORITY')))
                        //     {
                        //         $hasil = true;
                        //     }
                        //     else
                        //     {
                        //         if(strtoupper(\Session::get('USER_AUTHORITY')) == 'DEVELOPER')
                        //         {
                        //             $hasil = true;
                        //         }
                        //     }
                        // }
                    // }
                    
                    /*** alternative validation  ***/
                    // if(strtoupper($employee->DivisiID) == strtoupper(\Session::get('USER_DIVISI_ID'))) // ini untuk check apakah ada perubahan data divisi
                    //     {
                    //         $hasil = true;
                    //     }
                    //     else
                    //     {
                    //         if(EmployeeMultiDivisi::where([['EmployeeID', strtoupper(\Session::get('USER_ID'))], ['DivisiID', strtoupper(\Session::get('USER_DIVISI_ID'))]])->exists()) // ini untuk nge check kalau memang ada list multidivisi maka boleh
                    //         {
                    //             $hasil = true;
                    //         }
                    //     }
                    //     if($hasil)
                    //     {
                    //         if(strtoupper($employee->EmployeeID) == strtoupper(\Session::get('USER_ID')) && strtoupper($employee->CompanyID) == strtoupper(\Session::get('USER_COMPANY_ID')) && strtoupper($employee->BackendAuthority) == strtoupper(\Session::get('USER_AUTHORITY'))) // ini untuk check apakah ada perubahan data EmployeeID, CompanyID, Authority
                    //         {
                    //             $hasil = true;
                    //         }
                    //         else
                    //         {
                    //             if(strtoupper(\Session::get('USER_MAIN_AUTHORITY')) == 'DEVELOPER')
                    //             {
                    //                 $hasil = true;
                    //             }
                    //         }
                    //     }
                    /*** alternative validation  ***/
                }
            }            
        }
        else {
                
            $hasil = true;
        }

        return $hasil;
    }

    public function close()
    {
        try{

            $auth = true;
            if($this->except == false){
                $auth = $this->query->count();
            }

            if($auth == 0){
                if($this->request->ajax()){
                    throw new \Exception("You don`t have authority");
                }
                return Redirect::to('home')->with('unauthorized','You don\'t have authorization');
            }

            if(!self::authSession()){
                $log = $this->General->insertLog('AUTH','LOGOUT','SUCCESS');

                Session::flush();
                Session::put('unmatched', 'You are automatically log out because your employee data has been changed');

                return Redirect::to('/');
            }

        }
        catch(Exception $e){
            throw $e;
        }
    }

    // public function sync_employee($Password,$EmployeeID){
    //     try{
    //         $Employee = HrmEmployee::where([['Active','1'],['EmployeeID',$EmployeeID]])->first();
    //         if(!Hash::check($Password,$Employee->PasswordNew)){
    //             DB::transaction(function () {
    //                 $DataEmployee = [
    //                     'PasswordNew' => Hash::make($Employee->Password)
    //                 ];
    //                 $arrWheres = array([
    //                     'EmployeeID','=',$Employee->EmployeeID
    //                 ]);
    //                 $this->General->M_Update('Master_Employee',$DataEmployee,$arrWheres);
    //             });
    //         }
    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }
}
?>