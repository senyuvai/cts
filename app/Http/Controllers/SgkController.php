<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Sgk;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class SgkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* departments  Function Start Here */
    public function sgklar()
    {
        $self = 'sgklar';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $sgklar= Sgk::all();
        return view('admin.sgklar', compact('sgklar'));

    }

    /* addSgk  Function Start Here */
    public function addSgk(Request $request)
    {

        $self = 'sgklar';

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
            'sgk_name' => 'required', 'sgk_kodu' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sgklar')->withErrors($v->errors());
        }

        $sgk = Sgk::firstOrCreate(['sgk_name' => $request->sgk_name, 'sgk_kodu' => $request->sgk_kodu]);

        if ($sgk->wasRecentlyCreated) {
            return redirect('sgklar')->with([
                'message' => "SGK Ünvan Başarıyla Eklendi!"
            ]);

        } else {
            return redirect('sgklar')->with([
                'message' => "Girdiğiniz SGK Ünvan Önceden Kaydedilmiş!",
                'message_important' => true
            ]);
        }


    }

 /* updateDepartment  Function Start Here */
    public function updateSgk(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sgklar')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self = 'sgklar';
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
            'sgk_name' => 'required', 'sgk_kodu' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sgklar')->withErrors($v->errors());
        }
        $sgk = Sgk::find($cmd);
        $sgk_name = Input::get('sgk_name');
		$sgk_kodu = Input::get('sgk_kodu');

        if (($sgk_name != $sgk->sgk_name) or ($sgk_kodu != $sgk->sgk_kodu)) {

            $exist = Sgk::where('sgk_name', $sgk_name)->first();
			$exist2 = Sgk::where('sgk_kodu', $sgk_kodu)->first();
            if ($exist and $exist2) {
                return redirect('sgklar')->with([
                    'message' => "SGK Ünvan bulunmaktadır! Giremezsiniz",
                    'message_important' => true
                ]);
            }
        }
	


        if ($sgk) {
            $sgk->sgk_name = $sgk_name;
			 $sgk->sgk_kodu = $sgk_kodu;
            $sgk->save();

            return redirect('sgklar')->with([
                'message' => "SGK Ünvanı Başarıyla Güncellendi.",
            ]);

        } else {
            return redirect('sgklar')->with([
                'message' => "SGK Ünvanı Bulunamadı!",
                'message_important' => true
            ]);
        }
    }


    /* deleteSgk  Function Start Here */
    public function deleteSgk($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sgklar')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'sgklar';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $exist_check = Employee::where('sgk_id', $id)->where('user_name','!=','admin')->first();

        if ($exist_check) {
            return redirect('sgklar')->with([
                'message' => "SGK ünvanı en az bir çalışana tanımlı. Silinemez!",
                'message_important' => true
            ]);
        }

        $sgk = Sgk::find($id);
        if ($sgk) {


            $sgk->delete();

            return redirect('sgklar')->with([
                'message' => "SGK Ünvanı başarıyla silindi"
            ]);
        } else {
            return redirect('sgklar')->with([
                'message' => "SGK Ünvanı Bulunamadı!",
                'message_important' => true
            ]);
        }

    }


}
