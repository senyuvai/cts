<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingMembers extends Model
{
    protected $table='sys_training_members';
	
 public function employeetraining_getir()
    {
        return $this->hasOne('App\EmployeeTraining','id','training_id');
    }
	
	 public function trainingemployee_getir()
    {
        return $this->hasOne('App\Employee','id','emp_id');
    }
	
	
}
