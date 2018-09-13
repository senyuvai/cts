<?php

namespace App\Http\Controllers;

use App\Classes\permission;
use App\EgitimFirma;
use App\FirmaEgitimci;
use App\Employee;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

date_default_timezone_set(app_config('Timezone'));

class EgitimFirmaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* departments  Function Start Here */
    public function egitimfirmalari()
    {
        $self = 'egitimfirmalari';

        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }


        $egitimfirmalari = EgitimFirma::all();
        return view('admin.egitimfirmalari', compact('egitimfirmalari'));

    }

    /* addDepartment  Function Start Here */
    public function addEgitimFirma(Request $request)
    {

        $self = 'egitimfirmalari';

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
            'egitimfirma' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('egitimfirmalari')->withErrors($v->errors());
        }

        $egitimfirma = EgitimFirma::firstOrCreate(['egitimfirma' => $request->egitimfirma]);

        if ($egitimfirma->wasRecentlyCreated) {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Added Successfully')
            ]);

        } else {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Already Exist'),
                'message_important' => true
            ]);
        }


    }


    /* updateDepartment  Function Start Here */
    public function updateEgitimFirma(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('departments')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self = 'egitimfirmalari';
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
            'egitimfirma' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('egitimfirmalari')->withErrors($v->errors());
        }
        $egitimfirma = EgitimFirma::find($cmd);
        $egitimfirma_name = Input::get('egitimfirma');

        if ($egitimfirma_name != $egitimfirma->egitimfirma) {

            $exist = EgitimFirma::where('egitimfirma', $egitimfirma_name)->first();
            if ($exist) {
                return redirect('egitimfirmalari')->with([
                    'message' => language_data('Department Already Exist'),
                    'message_important' => true
                ]);
            }
        }


        if ($egitimfirma) {
            $egitimfirma->egitimfirma = $egitimfirma_name;
            $egitimfirma->save();

            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Updated Successfully')
            ]);

        } else {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }
    }


    /* deleteDepartment  Function Start Here */
    public function deleteEgitimFirma($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }

        $self = 'egitimfirmalari';
        if (\Auth::user()->user_name !== 'admin') {
            $get_perm = permission::permitted($self);

            if ($get_perm == 'access denied') {
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important' => true
                ]);
            }
        }

        $exist_check = Employee::where('egitimfirma', $id)->where('user_name','!=','admin')->first();

        if ($exist_check) {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('Employee added on this department. To remove; unassigned employee'),
                'message_important' => true
            ]);
        }

        $egitimfirma = EgitimFirma::find($id);
        if ($egitimfirma) {
            FirmaEgitimci::where('did', $id)->delete();
                       $egitimfirma->delete();


            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Deleted Successfully')
            ]);
        } else {
            return redirect('egitimfirmalari')->with([
                'message' => language_data('Department Not Found'),
                'message_important' => true
            ]);
        }

    }


}
