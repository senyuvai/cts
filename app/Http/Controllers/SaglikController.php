<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Employee;
use App\Saglik;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
date_default_timezone_set(app_config('Timezone'));
class SaglikController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /* expense  Function Start Here */
    public function saglik()
    {

        $self='saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $saglik = Saglik::all();
        $employee = Employee::where('user_name', '!=', 'admin')->get();
        return view('admin.saglik', compact('saglik', 'employee'));
    }

    /* postExpense  Function Start Here */
    public function postSaglik(Request $request)
    {

        $self='add-new-saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v = \Validator::make($request->all(), [
            
		            'rapor_tarih' => 'required', 'rapor_tur' => 'required',  

        ]);

        if ($v->fails()) {
            return redirect('saglik')->withErrors($v->errors());
        }

        $emp_name = Input::get('emp_name');
        $rapor_tarih = Input::get('rapor_tarih');
        $rapor_tarih=date('Y-m-d',strtotime($rapor_tarih));
        $rapor_tur = Input::get('rapor_tur');
        $saglik_raporu = Input::file('saglik_raporu');

        if ($saglik_raporu != '') {
            $destinationPath = public_path() . '/assets/employee_document/' . $emp_name . '/saglik_raporu/' .$rapor_tarih .'/';
            $saglik_raporu_name = $saglik_raporu->getClientOriginalName();
            Input::file('saglik_raporu')->move($destinationPath, $saglik_raporu_name);
        } else {
            $saglik_raporu_name = '';
        }

        $saglik = new Saglik();
        $saglik->rapor_tarih = $rapor_tarih;
        $saglik->purchase_by = $emp_name;
        $saglik->rapor_tur = $rapor_tur;
        $saglik->saglik_raporu = $saglik_raporu_name;
        $saglik->save();

        return redirect('saglik')->with([
            'message' => 'Sağlık raporu Başarıyla Eklendi'
        ]);

    }


    /* downloadBillCopy  Function Start Here */
    public function downloadSaglikRaporu($id)
    {
       
	$self='saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }
		
		$emp_name = Saglik::find($id)->purchase_by;
		$rapor_tarih = Saglik::find($id)->rapor_tarih;
        $file = Saglik::find($id)->saglik_raporu;

		return response()->download(public_path('assets/employee_document/'. $emp_name. '/saglik_raporu/'. $rapor_tarih.'/' .$file));
   	
	}

    /* deleteExpense  Function Start Here */
    public function deleteSaglik($id)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('saglik')->with([
                'message'=>language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $saglik = Saglik::find($id);
		$emp_name = Saglik::find($id)->purchase_by;
       		$rapor_no = Saglik::find($id)->rapor_no;
            $file = $saglik->saglik_raporu;
        if ($saglik) {
			   \File::deleteDirectory(public_path('assets/saglik_raporu/'.$emp_name.'/'.$rapor_no));
            $saglik->delete();

            return redirect('saglik')->with(['message' => 'Sağlık Kaydı Başarıyla Silindi']);
        } else {
            return redirect('saglik')->with([
                'message' => 'Sağlık Kaydı Bulunamadı!',
                'message_important' => true
            ]);
        }

    }

    /* editExpense  Function Start Here */
    public function editSaglik($id)
    {
        $self='saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $saglik = Saglik::find($id);

        if ($saglik) {
            $employee = Employee::where('user_name', '!=', 'admin')->get();
            return view('admin.edit-saglik', compact('saglik', 'employee'));

        } else {
            
					 return redirect('google');

        }

    }

    /* postEditExpense  Function Start Here */
    public function postEditSaglik(Request $request)
    {
        $self='saglik';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $cmd = Input::get('cmd');

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('saglik/edit/'.$cmd)->with([
                'message'=>language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $saglik = Saglik::find($cmd);

        if ($saglik) {
            $v = \Validator::make($request->all(), [
                
            ]);

            if ($v->fails()) {
                return redirect('saglik/edit/' . $cmd)->withErrors($v->errors());
            }


             $rapor_no = Input::get('rapor_no');
        $emp_name = Input::get('emp_name');
        $rapor_tarih = Input::get('rapor_tarih');
        $rapor_tarih=date('Y-m-d',strtotime($rapor_tarih));
		$ise_bas_tar = Input::get('ise_bas_tar');
        $ise_bas_tar=date('Y-m-d',strtotime($ise_bas_tar));
        $rapor_tur = Input::get('rapor_tur');
        $saglik_raporu = Input::file('saglik_raporu');

            if ($saglik_raporu != '') {
                $destinationPath = public_path() . '/assets/saglik_raporu/'. $emp_name . '/' .$rapor_no;

                File::delete($destinationPath.$saglik->saglik_raporu);

                $saglik_raporu_name = $saglik_raporu->getClientOriginalName();
                Input::file('saglik_raporu')->move($destinationPath, $saglik_raporu_name);

            } else {
                $saglik_raporu_name = $saglik->saglik_raporu;

            }

			$saglik->rapor_no = $rapor_no;
        $saglik->rapor_tarih = $rapor_tarih;
        $saglik->ise_bas_tar = $ise_bas_tar;
        $saglik->purchase_by = $emp_name;
        $saglik->rapor_tur = $rapor_tur;
        $saglik->saglik_raporu = $saglik_raporu_name;
            $saglik->save();

            return redirect('saglik')->with(['message' => 'Sağlık Raporu Kaydı Güncellendi']);
        } else {
            return redirect('saglik')->with([
                'message' => language_data('Sağlık Kaydı Bulunamadı!'),
                'message_important' => true
            ]);
        }
    }


}
