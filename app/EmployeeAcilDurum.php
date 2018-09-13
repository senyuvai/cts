<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeAcilDurum extends Model
{
    protected $table='sys_employee_acil_durumlar';
    protected $fillable=['emp_id','yakinlik_derecesi','yak_ad_soyad','yak_tckn','yak_gsm','yag_dog_tar','yag_dog_yer'];
}
