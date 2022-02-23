<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MasterLevel extends Model
{
    

    protected $table = 'Master_Level';
    protected $primaryKey = 'IndexLevel';
    

    protected $fillable = [
        'LevelID', 
        'LevelName', 
    ];

    public function pagingData($limit, object $obj){
        try{
            $data = (object) [];
            $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
            $sql = $this;
            if(request()->ajax()){
                $sql =  $sql->where(function($query) use ($keyword){
                    $query->where('LevelID', 'like', '%' .$keyword. '%')
                    ->orwhere('LevelName', 'like', '%' .$keyword. '%');
                });
            }
            $sql = $sql->orderBy('LevelID','ASC');
            $data->count = $sql->count();
            $data = $sql->paginate(5);
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_level($IndexLevel){
        $Level = DB::table($this->table)
                ->where('IndexLevel',$IndexLevel)
                ->orderby('LevelID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($Level), true);
        return $hasil;
    }
}
