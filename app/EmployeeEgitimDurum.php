<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeEgitimDurum extends Model
{
    protected $table='sys_employee_egitim_durumlar';
    protected $fillable=['emp_id','egitim_id','egitimfirma','firmaegitimci','egitim_bas_tar','egitim_bit_tar','egitim_yeri','sertifika_no','sertifika_tar','gecerlilik_suresi','puan'];

	public function egitim_name()
    {
	          return $this->hasOne('App\Egitim','id','egitim_id');
    }
	public function egitimfirma_name()
    {
	          return $this->hasOne('App\EgitimFirma','id','egitimfirma');
    }
	public function firmaegitimci_name()
    {
	          return $this->hasOne('App\FirmaEgitimci','id','firmaegitimci');
    }
   
}

   