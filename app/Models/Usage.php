<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;


class Usage extends Model
{
    

    protected $table = 'Usage';
    protected $primaryKey = 'IndexUsage';
    

    protected $fillable = [
        'IndexCustomer', 
        'CustomerID', 
        'Month', 
        'Year', 
        'StartMeter', 
        'EndMeter'
    ];

    // public function pagingData($limit, object $obj){
    //     try{
    //         $data = (object) [];
    //         $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
    //         $sql = $this;
    //         if(request()->ajax()){
    //             $sql =  $sql->where(function($query) use ($keyword){
    //                 $query->where('PriceID', 'like', '%' .$keyword. '%')
    //                 ->orwhere('Energy', 'like', '%' .$keyword. '%');
    //             });
    //         }
    //         $sql = $sql->orderBy('PriceID','ASC');
    //         $data->count = $sql->count();
    //         $data = $sql->paginate(5);
    //         return $data;
    //     }catch(Exception $e){
    //         throw $e;
    //     }
    // }

    public function get_usage($CustomerID){
        $Month = strtoupper(Carbon::now()->format('F'));

        $Usage = DB::table($this->table)
                ->join('Master_Customer','Master_Customer.CustomerID','=','Usage.CustomerID')
                ->join('Master_Price','Master_Price.IndexPrice','=','Master_Customer.IndexPrice')
                ->join('Bill','Bill.IndexUsage','=','Usage.IndexUsage')
                ->where('Master_Customer.CustomerID',$CustomerID)
                ->where('Usage.Month',$Month)
                ->orderby('Master_Customer.CustomerID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Usage), true);
        return $hasil;
    }
}
