<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MasterUser extends Model
{
    

    protected $table = 'Master_User';
    protected $primaryKey = 'IndexUser';
    

    protected $fillable = [
        'UserID', 
        'UserName', 
        'Email', 
        'Phone', 
        'Password', 
        'AdminName', 
        'IndexLevel'
    ];

    public function pagingData($limit, object $obj){
        try{
            $data = (object) [];
            $keyword = !empty(isset($obj->keyword)) ? $obj->keyword : null;
            $sql = $this;
            if(request()->ajax()){
                $sql =  $sql->where(function($query) use ($keyword){
                    $query->where('UserID', 'like', '%' .$keyword. '%')
                    ->orwhere('UserName', 'like', '%' .$keyword. '%');
                });
            }
            $sql = $sql->orderBy('UserID','ASC');
            $data->count = $sql->count();
            $data = $sql->paginate(5);
            return $data;
        }catch(Exception $e){
            throw $e;
        }
    }

    public function get_user($IndexUser){
        $User = DB::table($this->table)
                ->where('IndexUser',$IndexUser)
                ->orderby('UserID', 'asc')
                ->get();
        $hasil = json_decode(json_encode($User), true);
        return $hasil;
    }
}
