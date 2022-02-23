<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MasterCustomer extends Model
{
    

    protected $table = 'Master_Customer';
    protected $primaryKey = 'IndexCustomer';
    

    protected $fillable = [
        'CustomerID', 
        'CustomerName', 
        'Address', 
        'UserName', 
        'Password', 
        'KWHNo', 
        'IndexPrice', 
        'Active'
    ];

    public function pagingData($limit, object $obj){
        try{
            $data = (object) [];
            $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
            $sql =  $this::where(function($query) use ($keyword){
                        $query->where('CustomerID', 'like', '%' .$keyword. '%');
                    });
            if(request()->ajax()){
                $sql = (!empty(isset($obj->keyword))) ? $sql->where('CustomerID','=',$obj->keyword) : $sql;
            }
            // else{
            //     $sql = $sql->where('Active','=',1);
            // }
            $sql = $sql->orderBy('CustomerID','ASC');
            $data->count = $sql->count();
            $data = $sql->paginate(5);
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_customer($IndexCustomer){
        $Customer = DB::table($this->table)
                ->where('IndexCustomer',$IndexCustomer)
                ->orderby('CustomerID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Customer), true);
        return $hasil;
    }

    public function update_data($tbl,$arrField,$arrWheres)
    {
        $hasil = array();

        $sql = DB::table($tbl);
            foreach($arrWheres as $where) {
                $sql->where($where[0], $where[1], $where[2]);
            }
        $sql->update($arrField);

        $hasil['hasil'] = TRUE;
        $hasil['printQuery'] = DB::getQueryLog();

        return $hasil;
    }

    public function insert_data($tbl,$arrField)
    {
        $hasil = array();

        $sql = DB::table($tbl)->insertGetId($arrField);

        $hasil['hasil'] = TRUE;
        $hasil['lastInsertId'] = $sql;
        $hasil['printQuery'] = DB::getQueryLog();

        return $hasil;
    }
}
