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

class FirmaEgitimcilerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* designations  Function Start Here */
    public function firmaegitimciler()
    {
        $self='firmaegitimciler';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $egitimfirmalari = EgitimFirma::all();
        $firmaegitimciler = FirmaEgitimci::all();
		
        return view('admin.firmaegitimciler', compact('egitimfirmalari', 'firmaegitimciler'));
    }

    /* addDesignation  Function Start Here */
    public function addFirmaEgitimci(Request $request)
    {
        $self='firmaegitimciler';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v = \Validator::make($request->all(), [
            'firmaegitimci' => 'required', 'egitimfirma' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('firmaegitimciler')->withErrors($v->errors());
        }

        $firmaegitimciler = FirmaEgitimci::firstOrCreate(['did' => $request->egitimfirma, 'firmaegitimci' => $request->firmaegitimci]);

        if ($firmaegitimciler->wasRecentlyCreated) {
            return redirect('firmaegitimciler')->with([
                'message' => language_data('Designation Added Successfully')
            ]);

        } else {
            return redirect('firmaegitimciler')->with([
                'message' => language_data('Designation Already Exist'),
                'message_important' => true
            ]);
        }

    }

    /* deleteDesignation  Function Start Here */
    public function deleteFirmaEgitimci($id)
    {

        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('firmaegitimciler')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self='firmaegitimciler';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $exist_check=Employee::where('firmaegitimci',$id)->where('user_name','!=','admin')->first();

        if ($exist_check){
            return redirect('firmaegitimciler')->with([
                'message'=>language_data('Employee added on this designation. To remove; unassigned employee'),
                'message_important'=>true
            ]);
        }

        $firmaegitimci = FirmaEgitimci::find($id);
        if ($firmaegitimci) {
            $firmaegitimci->delete();

            return redirect('firmaegitimciler')->with([
                'message' => language_data('Designation Deleted Successfully'),
            ]);
        } else {
            return redirect('firmaegitimciler')->with([
                'message' => language_data('Designation Not Found'),
                'message_important' => true
            ]);
        }
    }

    /* updateDesignation  Function Start Here */
    public function updateFirmaEgitimci(Request $request)
    {
        $appStage = app_config('AppStage');
        if ($appStage == 'Demo') {
            return redirect('firmaegitimciler')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important' => true
            ]);
        }


        $self='firmaegitimciler';

        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $cmd = Input::get('cmd');

        $v = \Validator::make($request->all(), [
            'firmaegitimci' => 'required', 'egitimfirma' => 'required'
        ]);

        if ($v->fails()) {
            return redirect('firmaegitimciler')->withErrors($v->errors());
        }

        $firmaegitimci = trim(Input::get('firmaegitimci'));
        $egitimfirma = Input::get('egitimfirma');

        $des = FirmaEgitimci::find($cmd);

        $exist = FirmaEgitimci::where('did', $egitimfirma)->where('firmaegitimci', $firmaegitimci)->first();

        if ($firmaegitimci != $des->firmaegitimci AND $egitimfirma != $des->did) {

            if ($exist) {
                return redirect('firmaegitimciler')->with([
                    'message' => language_data('Designation Already Exist'),
                    'message_important' => true
                ]);
            }
        }

        $des->did = $egitimfirma;
        $des->firmaegitimci = $firmaegitimci;
        $des->save();

        return redirect('firmaegitimciler')->with([
            'message' => language_data('Designation Update Successfully')
        ]);

    }


}
