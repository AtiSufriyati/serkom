<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Usage;
use App\Models\MasterGeneral;

class PaymentController extends Controller
{

    protected $model;
    protected $request;
    // protected $table = 'Master_Client';
    public function __construct(){
    //     parent::__construct();
        // $this->middleware('auth.menu');
        $this->request = request();
        $this->model                    = new Payment();
        $this->model_usage              = new Usage();
        $this->model_general            = new MasterGeneral();
    }

    public function index(){
        try{
            $this->data['route_url'] = \Request::route()->getName();
            $this->data['payment'] = $this->model->pagingData(5, (object) $this->request->all());
            if($this->request->ajax()){
                return response()->json(view('pages.payment.table')->with($this->data)->render(), 200);
            }
            return view('pages.payment.page')->with($this->data);
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_usage(){
        if($this->request->ajax())
        {
            $Usage= $this->model_usage->get_usage($this->request->CustomerID,$this->request->Month);
            $data['Usage'] = $Usage;

        }
        return response()->json($data);
    }

    public function get_price(){
    //     if($this->request->ajax())
    //     {
    //         $Price= $this->model->get_price($this->request->IndexPrice);
    //         $data['Price'] = $Price;

    //     }
    //     return response()->json($data);
    }

    public function submit(){
    //     try{
    //         if($this->request->action == 'add'){
    //             $fields = array(
    //                 'PriceID'           => $this->request->PriceID, 
    //                 'Energy'            => $this->request->Energy, 
    //                 'PricePerKWH'       => $this->request->PricePerKWH, 
                    
    //             );
    //             $insert  = $this->model_general->insert_data('Master_Price', $fields);
    
    //             if($insert != null){
    //                 $data = [
    //                         'respon' => 'success',
    //                         'flag' => 'success',
    //                         'message' => 'You are successfully saved',
    //                         'url' => route('price')
    //                     ];
    //             }else{
    //                 $data = [
    //                         'respon' => 'failed',
    //                         'flag' => 'failed',
    //                         'message' => 'Data save has failed',
    //                     ];
    //             }
    //         }elseif($this->request->action == 'edit'){
    //             $fields = array(
    //                 'Energy'            => $this->request->Energy, 
    //                 'PricePerKWH'       => $this->request->PricePerKWH,  
    //             );
    //             $arr_index = array(
    //                 array('IndexPrice','=',$this->request->IndexPrice),
    //             );
    //             $update  = $this->model_general->update_data('Master_Price', $fields,$arr_index);
    
    //             if($update != null){
    //                 $data = [
    //                         'respon' => 'success',
    //                         'flag' => 'success',
    //                         'message' => 'Data saved successfully',
    //                     ];
    //             }else{
    //                 $data = [
    //                         'respon' => 'failed',
    //                         'flag' => 'failed',
    //                         'message' => 'Data save has failed',
    //                     ];
    //             }
    //         }
            

    //         return response()->json($data, 200);
    //     }catch(Exception $e){
    //         throw $e;
    //     }
    }
}
