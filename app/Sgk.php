<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sgk extends Model
{
    protected $table = 'sys_sgk';
    protected $fillable = ['sgk_name', 'sgk_kodu'];
}
