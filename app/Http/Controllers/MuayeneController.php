<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Employee;
use App\Muayene;
use App\MuayeneTur;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
date_default_timezone_set(app_config('Timezone'));
class MuayeneController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /* expense  Function Start Here */
    public function muayene()
    {

        $self='muayene';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $muayene = Muayene::all();
        $employee = Employee::where('user_name', '!=', 'admin')->get();
		$muayenetur = MuayeneTur::all();
        return view('admin.muayene', compact('muayene', 'employee', 'muayenetur'));
    }

    /* postExpense  Function Start Here */
    public function postMuayene(Request $request)
    {

        $self='add-new-muayene';
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
            
		            
		]);

        if ($v->fails()) {
            return redirect('muayene')->withErrors($v->errors());
        }

		$doktor = Input::get('doktor');
		$not = Input::get('not');
        $emp_name = Input::get('emp_name');
		$muayenetur_name = Input::get('muayenetur_name');
        $rapor_tarih = Input::get('rapor_tarih');
        $rapor_tarih=date('Y-m-d',strtotime($rapor_tarih));
        $muayene_raporu = Input::file('muayene_raporu');

        if ($muayene_raporu != '') {
            $destinationPath = public_path() .'/assets/employee_document/'.$emp_name.'/isg_raporu/'.$muayenetur_name.'/'.$rapor_tarih.'/';
            $muayene_raporu_name = $muayene_raporu->getClientOriginalName();
            Input::file('muayene_raporu')->move($destinationPath, $muayene_raporu_name);
        } else {
            $muayene_raporu_name = '';
        }

        $muayene = new Muayene();
		$muayene->doktor = $doktor;
		$muayene->not = $not;
        $muayene->rapor_tarih = $rapor_tarih;
        $muayene->purchase_by = $emp_name;
		$muayene->muayenetur = $muayenetur_name;
        $muayene->muayene_raporu = $muayene_raporu_name;
        $muayene->save();

        return redirect('muayene')->with([
            'message' => 'Sağlık raporu Başarıyla Eklendi'
        ]);

    }


    /* downloadBillCopy  Function Start Here */
    public function downloadMuayeneRaporu($id)
    {
       
	$self='muayene';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

		$emp_name = Muayene::find($id)->purchase_by;
		$muayenetur_name = Muayene::find($id)->muayenetur;
		$rapor_tarih = Muayene::find($id)->rapor_tarih;
        $file = Muayene::find($id)->muayene_raporu;

		return response()->download(public_path('assets/employee_document/'. $emp_name. '/isg_raporu/'. $muayenetur_name.'/'.$rapor_tarih.'/' .$file));
   	
	}

    /* deleteExpense  Function Start Here */
    public function deleteMuayene($id)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('saglik')->with([
                'message'=>language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='muayene';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $muayene= Muayene::find($id);
		$emp_name = Muayene::find($id)->purchase_by;
       		$rapor_no = Muayene::find($id)->rapor_no;
            $file = $muayene->muayene_raporu;
        if ($muayene) {
			   \File::deleteDirectory(public_path('assets/muayene_raporu/'.$emp_name.'/'.$rapor_no));
            $saglik->delete();

            return redirect('muayene')->with(['message' => 'Sağlık Kaydı Başarıyla Silindi']);
        } else {
            return redirect('muayene')->with([
                'message' => 'Sağlık Kaydı Bulunamadı!',
                'message_important' => true
            ]);
        }

    }

    /* editExpense  Function Start Here */
    public function editMuayene($id)
    {
        $self='muayene';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $muayene = Muayene::find($id);

        if ($muayene) {
            $employee = Employee::where('user_name', '!=', 'admin')->get();
			$muayenetur = MuayeneTur::all();
            return view('admin.edit-muayene', compact('muayene', 'employee','muayenetur'));

        } else {
            
					 return redirect('google');

        }

    }

    /* postEditExpense  Function Start Here */
    public function postEditMuayene(Request $request)
    {
        $self='muayene';
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
            return redirect('muayene/edit/'.$cmd)->with([
                'message'=>language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $muayene = Muayene::find($cmd);

        if ($muayene) {
            $v = \Validator::make($request->all(), [
                
            ]);

            if ($v->fails()) {
                return redirect('saglik/edit/' . $cmd)->withErrors($v->errors());
            }


        $rapor_no = Input::get('rapor_no');
		$doktor = Input::get('doktor');
		$not = Input::get('not');
        $emp_name = Input::get('emp_name');
		$muayenetur_name = Input::get('muayenetur_name');
        $rapor_tarih = Input::get('rapor_tarih');
        $rapor_tarih=date('Y-m-d',strtotime($rapor_tarih));
		$ise_bas_tar = Input::get('ise_bas_tar');
        $ise_bas_tar=date('Y-m-d',strtotime($ise_bas_tar));
        $muayene_raporu = Input::file('muayene_raporu');

            if ($muayene_raporu != '') {
                $destinationPath = public_path() . '/assets/muayene_raporu/'. $emp_name . '/' .$rapor_no;

                File::delete($destinationPath.$saglik->muayene_raporu);

                $muayene_raporu_name = $muayene_raporu->getClientOriginalName();
                Input::file('muayene_raporu')->move($destinationPath, $muayene_raporu_name);

            } else {
                $muayene_raporu_name = $muayene->muayene_raporu;

            }

			$muayene->rapor_no = $rapor_no;
        $muayene->rapor_tarih = $rapor_tarih;
        $muayene->ise_bas_tar = $ise_bas_tar;
        $muayene->purchase_by = $emp_name;
		$muayene->muayenetur = $muayenetur_name;
        $muayene->muayene_raporu = $muayene_raporu_name;
            $muayene->save();

            return redirect('muayene')->with(['message' => 'Sağlık Raporu Kaydı Güncellendi']);
        } else {
            return redirect('muayene')->with([
                'message' => language_data('Sağlık Kaydı Bulunamadı!'),
                'message_important' => true
            ]);
        }
    }


}
