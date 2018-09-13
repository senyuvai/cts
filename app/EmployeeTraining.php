<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeTraining extends Model
{
    protected $table='sys_employee_training';
	
 public function employeetrainingdetail_getir()
    {
        return $this->hasOne('App\TrainingDetails','id','trainingdetail');
    }
	
	
	
	 public function employeetrainingtrainer_getir()
    {
        return $this->hasOne('App\Trainers','id','trainer');
    }
	
	
	
	
	
}
