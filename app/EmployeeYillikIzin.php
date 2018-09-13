<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeYillikIzin extends Model
{
    protected $table='sys_employee_yillik_izinler';
    protected $fillable=['emp_id','izin_bas_tar','izin_bit_tar','gun_sure','imza_durum','izin_turu_not'];
}
