<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrainingDetails extends Model
{
    protected $table='sys_trainingdetails';
	    protected $fillable = ['trainingdetail_name','trainingdetail_hour','trainingdetail_aciklama'];

}
