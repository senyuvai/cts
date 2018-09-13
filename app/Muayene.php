<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muayene extends Model
{
    protected $table='sys_muayene';
	    protected $fillable=['rapor_no','rapor_tarih','ise_bas_tar','purchase_by','doktor','muayene_raporu','not'];

    /* employee_id  Function Start Here */
    public function employee_info()
    {
        return $this->hasOne('App\Employee','id','purchase_by');
    }
	 public function muayenetur_info()
    {
        return $this->hasOne('App\MuayeneTur','id','muayenetur');
    }

}
