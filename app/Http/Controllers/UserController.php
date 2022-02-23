<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterUser;
use App\Models\MasterGeneral;

class UserController extends Controller
{

    protected $model;
    protected $request;
    // protected $table = 'Master_Client';
    public function __construct(){
    //     parent::__construct();
        // $this->middleware('auth.menu');
        $this->request = request();
        $this->model                    = new MasterUser();
        $this->model_general            = new MasterGeneral();
    }

    public function index(){
        try{
            $tes = $this->request->all();
            $this->data['route_url'] = \Request::route()->getName();
            $this->data['user'] = $this->model->pagingData(5, (object) $this->request->all());
            if($this->request->ajax()){
                return response()->json(view('pages.user.table')->with($this->data)->render(), 200);
            }

            return view('pages.user.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_user(){
        if($this->request->ajax())
        {
            $User= $this->model->get_user($this->request->IndexUser);
            $data['User'] = $User;

        }
        return response()->json($data);
    }

    public function submit(){
        try{
            if($this->request->action == 'add'){
                $fields = array(
                    'UserID'        => 'USR002', 
                    'UserName'      => $this->request->Username, 
                    'Email'         => $this->request->Email, 
                    'AdminName'     => $this->request->AdminName, 
                    'Password'      => 'User@123', 
                    'Phone'         => $this->request->Phone, 
                    'IndexLevel'    => $this->request->IndexLevel, 
                );
                $insert  = $this->model_general->insert_data('Master_User', $fields);
    
                if($insert != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'You are successfully saved',
                            'url' => route('user')
                        ];
                }else{
                    $data = [
                            'respon' => 'failed',
                            'flag' => 'failed',
                            'message' => 'Data save has failed',
                        ];
                }
            }elseif($this->request->action == 'edit'){
                $fields = array(
                    'UserName'      => $this->request->Username, 
                    'Email'         => $this->request->Email, 
                    'AdminName'     => $this->request->AdminName, 
                    'Phone'         => $this->request->Phone, 
                    'IndexLevel'    => $this->request->IndexLevel, 
                );
                $arr_index = array(
                    array('IndexUser','=',$this->request->IndexUser),
                );
                $update  = $this->model_general->update_data('Master_User', $fields,$arr_index);
    
                if($update != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'Data saved successfully',
                        ];
                }else{
                    $data = [
                            'respon' => 'failed',
                            'flag' => 'failed',
                            'message' => 'Data save has failed',
                        ];
                }
            }
            

            return response()->json($data, 200);
        }catch(Exception $e){
            throw $e;
        }
    }
}
