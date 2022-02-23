<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterPrice;
use App\Models\MasterGeneral;

class PriceController extends Controller
{

    protected $model;
    protected $request;
    // protected $table = 'Master_Client';
    public function __construct(){
    //     parent::__construct();
        // $this->middleware('auth.menu');
        $this->request = request();
        $this->model                    = new MasterPrice();
        $this->model_general            = new MasterGeneral();
    }

    public function index(){
        try{
            $tes = $this->request->all();
            $this->data['route_url'] = \Request::route()->getName();
            $this->data['price'] = $this->model->pagingData(5, (object) $this->request->all());
            if($this->request->ajax()){
                return response()->json(view('pages.price.table')->with($this->data)->render(), 200);
            }

            return view('pages.price.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_price(){
        if($this->request->ajax())
        {
            $Price= $this->model->get_price($this->request->IndexPrice);
            $data['Price'] = $Price;

        }
        return response()->json($data);
    }

    public function submit(){
        try{
            if($this->request->action == 'add'){
                $fields = array(
                    'PriceID'           => $this->request->PriceID, 
                    'Energy'            => $this->request->Energy, 
                    'PricePerKWH'       => $this->request->PricePerKWH, 
                    
                );
                $insert  = $this->model_general->insert_data('Master_Price', $fields);
    
                if($insert != null){
                    $data = [
                            'respon' => 'success',
                            'flag' => 'success',
                            'message' => 'You are successfully saved',
                            'url' => route('price')
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
                    'Energy'            => $this->request->Energy, 
                    'PricePerKWH'       => $this->request->PricePerKWH,  
                );
                $arr_index = array(
                    array('IndexPrice','=',$this->request->IndexPrice),
                );
                $update  = $this->model_general->update_data('Master_Price', $fields,$arr_index);
    
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
