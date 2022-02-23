<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class MasterGeneral extends Model
{

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
