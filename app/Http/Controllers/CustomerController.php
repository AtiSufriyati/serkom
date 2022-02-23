<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterCustomer;


class CustomerController extends Controller
{

    protected $model;
    protected $request;
    // protected $table = 'Master_Client';
    public function __construct(){
    //     parent::__construct();
        // $this->middleware('auth.menu');
        $this->request = request();
        $this->model                    = new MasterCustomer();
    }

    public function index(){
        try{
            $tes = $this->request->all();
            $this->data['route_url'] = \Request::route()->getName();
            $this->data['customer'] = $this->model->pagingData(5, (object) $this->request->all());
            if($this->request->ajax()){
                return response()->json(view('pages.customer.table')->with($this->data)->render(), 200);
            }

            return view('pages.customer.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_customer(){
        if($this->request->ajax())
        {
            $Customer= $this->model->get_customer($this->request->IndexCustomer);
            $data['Customer'] = $Customer;

        }
        return response()->json($data);
    }

    public function submit(){
        try{
            if($this->request->action == 'add'){
                $fields = array(
                    'CustomerID'        => 'CUS100', 
                    'CustomerName'      => $this->request->CustomerName, 
                    'Address'           => $this->request->Address, 
                    'UserName'          => $this->request->Username, 
                    'Password'          => 'Password@123', 
                    'KWHNo'             => $this->request->KWHNo, 
                    'IndexPrice'        => 1, 
                    'Active'            => "ACTIVE",
                );
                $insert  = $this->model->insert_data('Master_Customer', $fields);
    
                if($insert != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'You are successfully saved',
                            'url' => route('customer')
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
                    'CustomerName'      => $this->request->CustomerName, 
                    'Address'           => $this->request->Address, 
                    'UserName'          => $this->request->Username, 
                    'Password'          => 'Password@123', 
                    'KWHNo'             => $this->request->KWHNo, 
                    'IndexPrice'        => 1, 
                );
                $arr_index = array(
                    array('IndexCustomer','=',$this->request->IndexCustomer),
                );
                $update  = $this->model->update_data('Master_Customer', $fields,$arr_index);
    
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
