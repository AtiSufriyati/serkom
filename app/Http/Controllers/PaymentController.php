<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Usage;
use App\Models\MasterGeneral;
use Carbon\Carbon;
use Session;

class PaymentController extends Controller
{

    protected $model;
    protected $request;
    public function __construct(){
        $this->request = request();
        $this->model                    = new Payment();
        $this->model_usage              = new Usage();
        $this->model_general            = new MasterGeneral();
    }

    public function index(){
        // function yang digunakan untuk tampilan awal modul dibuka
        try{
            // $value = $this->request->session()->get('key');
            // Session::put('UserName','ATI');
            // dd(Session::get('UserName'));
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
        // function get yang digunakan untuk mengambil data dari table usage / yang diperlukan
        if($this->request->ajax())
        {
            $Usage= $this->model_usage->get_usage($this->request->CustomerID);
            $data['Usage'] = $Usage;

        }
        return response()->json($data);
    }

    public function get_payment(){
        // function get yang digunakan untuk mengambil data dari table payment / yang diperlukan
        if($this->request->ajax())
        {
            $Payment= $this->model->get_payment($this->request->IndexPayment);
            $data['Payment'] = $Payment;

        }
        return response()->json($data);
    }
    
    public function submit(){
    // function yang digunakan untuk proses menyimpan / update ke database
        try{
            $fields = array(
                'IndexBill' => $this->request->IndexBill, 
                'CustomerID'    => $this->request->CustomerID, 
                'PaymentDate'   => Carbon::now(), 
                'Month' => explode('/',$this->request->Periode)[0], 
                'AdminCharge'   => str_replace(',','',$this->request->AdminCharge), 
                'TotalPayment'  => str_replace(',','',$this->request->TotalPayment), 
                'IndexUser'  => '1',
            );
            $insert  = $this->model_general->insert_data('Payment', $fields);
            $fields_bill = array(
                'Status' => 'PAID', 
            );
            $arr_index = array(
                array('IndexBill','=',$this->request->IndexBill),
            );
            $update  = $this->model_general->update_data('Bill', $fields_bill,$arr_index);

            if($insert != null){
                $data = [
                        'respon' => 'success',
                        'flag' => 'success',
                        'message' => 'You are successfully saved',
                        'url' => route('payment')
                    ];
            }else{
                $data = [
                        'respon' => 'failed',
                        'flag' => 'failed',
                        'message' => 'Data save has failed',
                    ];
            }
            
            
            return response()->json($data, 200);
        }catch(Exception $e){
            throw $e;
            //jika terjadi error makan akan di tangkap dan di respon dalam bentuk pesan error
        }
    }
}
