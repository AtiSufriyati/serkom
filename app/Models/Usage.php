<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

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

    public function get_usage($CustomerID,$Month){
        $Usage = DB::table($this->table)
                ->where('CustomerID',$CustomerID)
                ->where('Month',$Month)
                ->orderby('CustomerID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Usage), true);
        return $hasil;
    }
}
