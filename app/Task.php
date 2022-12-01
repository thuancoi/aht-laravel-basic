<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Task extends Model
{

    protected $table = "tasks";
    protected $fillable = ['id', 'title', 'description'];
    public function loadListWithPager($params = [])
    {
        $query = DB::table($this->table)
            ->select($this->fillable);
        $list = $query->paginate(10);
        return $list;
    }

    public function saveNew($param = [])
    {
        $data = $param['cols'];
        $respon = DB::table($this->table)->insertGetId($data);
        return $respon;
    }
    public function loadOne($id, $param = null)
    {
        $query = DB::table($this->table)
            ->where('id', '=', $id);
        $one = $query->first();
        return $one;
    }
    public function saveUpdate($param)
    {
        if (empty($param['cols']['id'])) {
            Session::flash('error', 'Không xác định bản ghi cần cập nhật');
            return null;
        }
        $dataupdate = [];
        foreach ($param['cols'] as $col => $val) {
            if ($col == 'id') continue;
            if (in_array($col, $this->fillable)) {
                $dataupdate[$col] = (strlen($val) == 0) ?  null : $val;
            }
        }
        $res = DB::table($this->table)
            ->where('id', $param['cols']['id'])
            ->update($dataupdate);
        return $res;
    }
}