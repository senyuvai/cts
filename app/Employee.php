<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'sys_employee';

    /* designation  Function Start Here */
    public function designation_name()
    {
        return $this->hasOne('App\Designation','id','designation');
    }
	

    /* department  Function Start Here */
    public function department_name()
    {
        return $this->hasOne('App\Department','id','department');
    }
	
	 /* sgk  Function Start Here */
    public function sgk_name()
    {
        return $this->hasOne('App\Sgk','id','sgk');
    }
	

	public function emptrainings(){
			
		return $this->belongsToMany('App\EmployeeTraining');
	
	}
	
	
}


