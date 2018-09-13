<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Egitim;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class EgitimController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* departments  Function Start Here */
    public function egitimler()
    {
        $self = 'egitimler';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $egitimler= Egitim::all();
        return view('admin.egitimler', compact('egitimler'));

    }

    /* addSgk  Function Start Here */
    public function addEgitim(Request $request)
    {

        $self = 'egitimler';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'egitim_name' => 'required', 'egitim_suresi' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('egitimler')->withErrors($v->errors());
        }

        $egitim = Egitim::firstOrCreate(['egitim_name' => $request->egitim_name, 'egitim_suresi' => $request->egitim_suresi]);

        if ($egitim->wasRecentlyCreated) {
            return redirect('egitimler')->with([
                'message' => "SGK Ünvan Başarıyla Eklendi!"
            ]);

        } else {
            return redirect('egitim')->with([
                'message' => "Girdiğiniz SGK Ünvan Önceden Kaydedilmiş!",
                'message_important' => true
            ]);
        }


    }

 /* updateDepartment  Function Start Here */
    public function updateEgitim(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('egitimler')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self = 'egitimler';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $cmd = Input::get('cmd');
        $v = \Validator::make($request->all(), [
            'egitim_name' => 'required', 'egitim_suresi' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('egitimler')->withErrors($v->errors());
        }
        $egitim = Egitim::find($cmd);
        $egitim_name = Input::get('egitim_name');
		$egitim_suresi = Input::get('egitim_suresi');

        if (($egitim_name != $egitim->egitim_name) or ($egitim_suresi != $egitim->egitim_suresi)) {

            $exist = Egitim::where('egitim_name', $egitim_name)->first();
			$exist2 = Egitim::where('egitim_suresi', $egitim_suresi)->first();
            if ($exist and $exist2) {
                return redirect('egitimler')->with([
                    'message' => "SGK Ünvan bulunmaktadır! Giremezsiniz",
                    'message_important' => true
                ]);
            }
        }
	


        if ($egitim) {
            $egitim->egitim_name = $egitim_name;
			 $egitim->egitim_suresi = $egitim_suresi;
            $egitim->save();

            return redirect('egitimler')->with([
                'message' => "SGK Ünvanı Başarıyla Güncellendi.",
            ]);

        } else {
            return redirect('egitimler')->with([
                'message' => "SGK Ünvanı Bulunamadı!",
                'message_important' => true
            ]);
        }
    }


    /* deleteSgk  Function Start Here */
    public function deleteEgitim($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('egitimler')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'egitimler';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $exist_check = Employee::where('egitim_id', $id)->where('user_name','!=','admin')->first();

        if ($exist_check) {
            return redirect('egitimler')->with([
                'message' => "SGK ünvanı en az bir çalışana tanımlı. Silinemez!",
                'message_important' => true
            ]);
        }

        $egitim = Egitim::find($id);
        if ($egitim) {


            $egitim->delete();

            return redirect('egitimler')->with([
                'message' => "SGK Ünvanı başarıyla silindi"
            ]);
        } else {
            return redirect('egitimler')->with([
                'message' => "SGK Ünvanı Bulunamadı!",
                'message_important' => true
            ]);
        }

    }


}
