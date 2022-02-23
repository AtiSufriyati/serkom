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
                    ->orwhere('Month', 'like', '%' .$keyword. '%');
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

}
