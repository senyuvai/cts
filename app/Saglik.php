<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saglik extends Model
{
    protected $table='sys_saglik';
	    protected $fillable=['rapor_no','rapor_tarih','ise_bas_tar','purchase_by','rapor_tur','saglik_raporu'];

    /* employee_id  Function Start Here */
    public function employee_info()
    {
        return $this->hasOne('App\Employee','id','purchase_by');
    }

}
