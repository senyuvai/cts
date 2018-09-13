<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeSaglikDurumu extends Model
{
    protected $table='sys_employee_saglik_durumlari';
    protected $fillable=['emp_id','per_mua_form_tar','sag_rap_tar','doktor','not'];
}
