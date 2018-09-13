<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MuayeneTur extends Model
{
    protected $table = 'sys_muayenetur';
    protected $fillable = ['muayenetur','gecerlilik_suresi'];
}
