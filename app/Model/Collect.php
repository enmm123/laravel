<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    //关联的数据表
    public $table = 'collect';
    //允许批量操作的字段
    public $guarded = [];
    //是否维护crated_at 和 updated_at字段
    public $timestamps = false;
}
