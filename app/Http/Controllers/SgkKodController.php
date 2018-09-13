<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\Department;
use App\SgkKod;
use App\Designation;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class SgkKodController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* departments  Function Start Here */
    public function sgkkodlar()
    {
        $self = 'sgkkodlar';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $sgkkodlar = SgkKod::all();
        return view('admin.sgkkodlar', compact('sgkkodlar'));

    }

    /* addDepartment  Function Start Here */
    public function addSgkKod(Request $request)
    {

        $self = 'sgkkodlar';

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
            'sgkkod' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sgkkodlar')->withErrors($v->errors());
        }

        $department = Department::firstOrCreate(['sgkkod' => $request->sgkkod]);

        if ($department->wasRecentlyCreated) {
            return redirect('sgkkodlar')->with([
                'message' => language_data('Department Added Successfully')
            ]);

        } else {
            return redirect('sgkkodlar')->with([
                'message' => language_data('Department Already Exist'),
                'message_important' => true
            ]);
        }


    }


    /* updateDepartment  Function Start Here */
    public function updateSgkKod(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sgkkodlar')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self = 'departments';
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
            'sgkkod' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('sgkkodlar')->withErrors($v->errors());
        }
        $department = Department::find($cmd);
        $department_name = Input::get('sgkkod');

        if ($department_name != $department->department) {

            $exist = SgkKod::where('sgkkod', $sgkkod_name)->first();
            if ($exist) {
                return redirect('sgkkodlar')->with([
                    'message' => language_data('Department Already Exist'),
                    'message_important' => true
                ]);
            }
        }


        if ($sgkkod) {
            $sgkkod->sgkkod = $sgk_name;
            $sgkkod->save();

            return redirect('sgkkodlar')->with([
                'message' => language_data('Department Updated Successfully')
            ]);

        } else {
            return redirect('sgkkodlar')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }
    }


    /* deleteDepartment  Function Start Here */
    public function deleteSgkKod($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('sgkkodlar')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'sgkkodlar';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $exist_check = Employee::where('sgkkod', $id)->where('user_name','!=','admin')->first();

        if ($exist_check) {
            return redirect('sgkkodlar')->with([
                'message' => language_data('Employee added on this department. To remove; unassigned employee'),
                'message_important' => true
            ]);
        }

        $sgkkod = SgkKod::find($id);
        if ($sgkkod) {

            Designation::where('did', $id)->delete();
            $department->delete();

            return redirect('departments')->with([
                'message' => language_data('Department Deleted Successfully')
            ]);
        } else {
            return redirect('departments')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }

    }


}
