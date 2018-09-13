<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\MuayeneTur;
use App\Muayene;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class MuayeneTurController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* departments  Function Start Here */
    public function muayeneturler()
    {
        $self = 'muayeneturler';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $muayeneturler = MuayeneTur::all();
        return view('admin.muayeneturler', compact('muayeneturler'));

    }

    /* addDepartment  Function Start Here */
    public function addMuayeneTur(Request $request)
    {

        $self = 'muayeneturler';

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
            'muayenetur' => 'required', 'gecerlilik_suresi' => 'required'

        ]);

        if ($v->fails()) {
            return redirect('muayeneturler')->withErrors($v->errors());
        }

        $muayenetur = MuayeneTur::firstOrCreate(['muayenetur' => $request->muayenetur,'gecerlilik_suresi' => $request->gecerlilik_suresi]);

        if ($muayenetur->wasRecentlyCreated) {
            return redirect('muayeneturler')->with([
                'message' => 'Muayene Tür Başarıyla Eklendi'
            ]);

        } else {
            return redirect('muayeneturler')->with([
                'message' => language_data('Department Already Exist'),
                'message_important' => true
            ]);
        }


    }


    /* updateDepartment  Function Start Here */
    public function updateMuayeneTur(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('departments')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self = 'muayeneturler';
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
            'department' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('muayeneturler')->withErrors($v->errors());
        }
        $muayenetur = MuayeneTur::find($cmd);
        $muayenetur_name = Input::get('muayenetur');
		$gecerlilik_suresi = Input::get('gecerlilik_suresi');

        if ($muayenetur_name != $muayenetur->muayenetur) {

            $exist = MuayeneTur::where('muayenetur', $muayenetur_name)->first();
            if ($exist) {
                return redirect('muayeneturler')->with([
                    'message' => language_data('Department Already Exist'),
                    'message_important' => true
                ]);
            }
        }


        if ($muayenetur) {
            $muayenetur->muayenetur = $muayenetur_name;
			$muayenetur->gecerlilik_suresi = $gecerlilik_suresi;
            $muayenetur->save();

            return redirect('muayeneturler')->with([
                'message' => language_data('Department Updated Successfully')
            ]);

        } else {
            return redirect('muayeneturler')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }
    }


    /* deleteDepartment  Function Start Here */
    public function deleteMuayeneTur($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('departments')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'muayeneturler';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $exist_check = Muayene::where('muayenetur', $id)->where('user_name','!=','admin')->first();

        if ($exist_check) {
            return redirect('muayeneler')->with([
                'message' => language_data('Employee added on this department. To remove; unassigned employee'),
                'message_important' => true
            ]);
        }

        $muayenetur = MuayeneTur::find($id);
        if ($muayenetur) {

            $muayenetur->delete();

            return redirect('muayeneturler')->with([
                'message' => language_data('Department Deleted Successfully')
            ]);
        } else {
            return redirect('muayeneturler')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }

    }


}
