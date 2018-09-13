<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Egitim extends Model
{
    protected $table = 'sys_egitim';
    protected $fillable = ['egitim_name', 'egitim_suresi'];
}
