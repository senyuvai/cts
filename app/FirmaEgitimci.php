<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FirmaEgitimci extends Model
{
    protected $table = 'sys_firmaegitimci';
    protected $fillable = ['did','firmaegitimci'];

    /* department_name  Function Start Here */
    public function egitimfirma_name()
    {
        return $this->hasOne('App\EgitimFirma','id','did');
    }


}
