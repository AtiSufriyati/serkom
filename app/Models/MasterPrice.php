<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MasterPrice extends Model
{
    

    protected $table = 'Master_Price';
    protected $primaryKey = 'IndexPrice';
    

    protected $fillable = [
        'PriceID', 
        'Energy', 
        'PricePerKWH', 
    ];

    public function pagingData($limit, object $obj){
        try{
            $data = (object) [];
            $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
            $sql = $this;
            if(request()->ajax()){
                $sql =  $sql->where(function($query) use ($keyword){
                    $query->where('PriceID', 'like', '%' .$keyword. '%')
                    ->orwhere('Energy', 'like', '%' .$keyword. '%');
                });
            }
            $sql = $sql->orderBy('PriceID','ASC');
            $data->count = $sql->count();
            $data = $sql->paginate(5);
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_price($IndexPrice){
        $Price = DB::table($this->table)
                ->where('IndexPrice',$IndexPrice)
                ->orderby('PriceID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Price), true);
        return $hasil;
    }
}
