<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payment extends Model
{
    

    protected $table = 'Payment';
    protected $primaryKey = 'IndexPayment';
    

    protected $fillable = [
        'IndexBill', 
        'IndexCustomer', 
        'PaymentDate', 
        'Month', 
        'AdminCharge', 
        'TotalPayment', 
        'IndexUser' 
    ];

    public function pagingData($limit, object $obj){
        try{
            $data = (object) [];
            $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
            $sql = $this;
            if(request()->ajax()){
                $sql =  $sql->where(function($query) use ($keyword){
                    $query->where('Month', 'like', '%' .$keyword. '%')
                    ->orwhere('CustomerID', 'like', '%' .$keyword. '%');
                });
            }
            $sql = $sql->orderBy('IndexPayment','ASC');
            $data->count = $sql->count();
            $data = $sql->paginate(5);
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_payment($IndexPayment){

        $Payment = DB::table($this->table)
                ->join('Master_Customer','Master_Customer.CustomerID','=','Payment.CustomerID')
                ->join('Master_Price','Master_Price.IndexPrice','=','Master_Customer.IndexPrice')
                ->join('Bill','Bill.IndexBill','=','Payment.IndexBill')
                ->join('Usage','Usage.IndexUsage','=','Bill.IndexUsage')
                ->where('Payment.IndexPayment',$IndexPayment)
                ->orderby('Master_Customer.CustomerID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Payment), true);
        return $hasil;
    }

}
