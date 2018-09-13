<?php

namespace App\Http\Controllers;

use App\TrainingApplicants;
use App\Classes\permission;
use App\Department;
use App\Employee;
use App\EmployeeTraining;
use App\Trainers;
use App\TrainingDetails;
use App\TrainingEvaluations;
use App\TrainingEvents;
use App\TrainingEventsEmployee;
use App\TrainingEventsTrainers;
use App\TrainingMembers;
use App\TrainingNeedsAssessment;
use App\TrainingNeedsAssessmentMembers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class TrainingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /* trainers  Function Start Here */
    public function trainers()
    {
        $self='trainers';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $trainers=Trainers::all();
        return view('admin.trainers',compact('trainers'));
    }
	
	public function trainingdetails()
    {
        $self='trainingdetails';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $trainingdetails=TrainingDetails::all();
        return view('admin.trainingdetails',compact('trainingdetails'));
    }
	
	/* postNewTrainer  Function Start Here */
    public function postNewTrainingDetail(Request $request)
    {
        $self='add-new-trainingdetail';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v=\Validator::make($request->all(),[
            'trainingdetail_name'=>'required','trainingdetail_hour'=>'required','trainingdetail_aciklama'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/trainingdetails')->withErrors($v->errors());
        }

        $trainingdetail = TrainingDetails::firstOrCreate(['trainingdetail_name' => $request->trainingdetail_name, 'trainingdetail_hour' => $request->trainingdetail_hour, 'trainingdetail_aciklama' => $request->trainingdetail_aciklama]);

        if ($trainingdetail->wasRecentlyCreated) {
            return redirect('training/trainingdetails')->with([
                'message' => "SGK Ünvan Başarıyla Eklendi!"
            ]);

        } else {
            return redirect('training/trainingdetails')->with([
                'message' => "Girdiğiniz SGK Ünvan Önceden Kaydedilmiş!",
                'message_important' => true
            ]);
        }
    }

    /* deleteTrainer  Function Start Here */
    public function deleteTrainingDetail($id)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/trainers')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }


        $self='trainingdetails';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $trainingdetail=TrainingDetails::find($id);

        if($trainingdetail){
            $trainingdetail->delete();

            return redirect('training/trainingdetails')->with([
                'message'=> language_data('Trainer deleted successfully')
            ]);

        }else{
            return redirect('training/trainingdetails')->with([
                'message'=> language_data('Trainer info not found')
            ]);
        }

    }

    /* viewTrainersInfo  Function Start Here */
    public function viewTrainingDetailsInfo($id)
    {

        $self='trainingdetails';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $trainingdetail=TrainingDetails::find($id);
		$trainingemployees=EmployeeTraining::where('trainingdetail',$id)->get(['id'])->toArray();
		$notintrainings=TrainingMembers::whereNotIn('training_id',$trainingemployees)->groupBy(['emp_id'])->get();
		
        if($trainingdetail){
            return view('admin.view-trainingdetails-info',compact('trainingdetail','notintrainings'));

        }else{
            return redirect('training/trainingdetails')->with([
                'message'=> 'Eğitim Tanımı Bulunamadı',
                'message_important'=>true
            ]);
        }
    }

    /* postTrainerUpdateInfo  Function Start Here */
    public function postTrainingDetailUpdateInfo(Request $request)
    {

        $self='trainingdetails';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $cmd=Input::get('cmd');

        $v=\Validator::make($request->all(),[

		]);

        if($v->fails()){
            return redirect('training/view-trainingdetails-info/'.$cmd)->withErrors($v->errors());
        }

        $trainingdetail=TrainingDetails::find($cmd);

        if($trainingdetail){
            $trainingdetail->trainingdetail_name=$request->trainingdetail_name;
            $trainingdetail->trainingdetail_hour=$request->trainingdetail_hour;
            $trainingdetail->trainingdetail_aciklama=$request->trainingdetail_aciklama;
             $trainer->save();

            return redirect('training/trainingdetails')->with([
                'message'=> language_data('Trainer updated successfully')
            ]);
        }else{
            return redirect('training/trainingdetails')->with([
                'message'=> language_data('Trainer info not found'),
                'message_important'=>true
            ]);
        }
    }


    /* postNewTrainer  Function Start Here */
    public function postNewTrainer(Request $request)
    {
        $self='add-new-trainer';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $v=\Validator::make($request->all(),[
            'first_name'=>'required', 'organization'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/trainers')->withErrors($v->errors());
        }

        $trainer=new Trainers();
        $trainer->first_name=$request->first_name;
        $trainer->organization=$request->organization;
        $trainer->address=$request->address;
        $trainer->email_address=$request->email;
        $trainer->phone=$request->phone;
        $trainer->expertise=$request->trainer_expertise;
        $trainer->save();

        return redirect('training/trainers')->with([
            'message'=> 'Egitimci Başarıyla Eklendi'
        ]);
    }

    /* deleteTrainer  Function Start Here */
    public function deleteTrainer($id)
    {
        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/trainers')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }


        $self='trainers';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $trainer=Trainers::find($id);
		$trainer_training=EmployeeTraining::where('trainer',$id)->count();

     

		if($trainer){
			   if($trainer_training > 0){
            return redirect('training/trainers')->with([
                'message'=> 'Eğitmen Eğitimde Görev ALdığı İçin Silemezsiniz'
            ]);}
				   else{
            $trainer->delete();
            return redirect('training/trainers')->with([
                'message'=> 'Eğitmen Başarıyla Silindi'
            ]);
				   }
        }else{
            return redirect('training/trainers')->with([
                'message'=> 'Eğitimci Bulunamadı!'
            ]);
        }

    }

    /* viewTrainersInfo  Function Start Here */
    public function viewTrainersInfo($id)
    {

        $self='trainers';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $trainer=Trainers::find($id);

        if($trainer){
            return view('admin.view-trainer-info',compact('trainer'));

        }else{
            return redirect('training/trainers')->with([
                'message'=> language_data('Trainer info not found'),
                'message_important'=>true
            ]);
        }
    }

    /* postTrainerUpdateInfo  Function Start Here */
    public function postTrainerUpdateInfo(Request $request)
    {

        $self='trainers';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $cmd=Input::get('cmd');

        $v=\Validator::make($request->all(),[
            'first_name'=>'required', 'organization'=>'required','email'=>'required','phone'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/view-trainers-info/'.$cmd)->withErrors($v->errors());
        }

        $trainer=Trainers::find($cmd);

        if($trainer){
            $trainer->first_name=$request->first_name;
            $trainer->organization=$request->organization;
            $trainer->address=$request->address;
            $trainer->email_address=$request->email;
            $trainer->phone=$request->phone;
            $trainer->expertise=$request->trainer_expertise;
            $trainer->save();

            return redirect('training/trainers')->with([
                'message'=> 'Eğitmen Başarıyla Güncellendi'
            ]);
        }else{
            return redirect('training/trainers')->with([
                'message'=> 'Eğitmen Bulunamadı',
                'message_important'=>true
            ]);
        }
    }

    /* employeeTraining  Function Start Here */
    public function employeeTraining()
    {

        $self='employee-training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $emp_training=EmployeeTraining::all();
        $employee=Employee::where('status','active')->where('user_name','!=','admin')->get();
        $trainers=Trainers::all();
		$trainingdetails=TrainingDetails::all();
        return view('admin.employee-training',compact('emp_training','employee','trainers','trainingdetails'));
    }

    /* postNewTraining  Function Start Here */
    public function postNewTraining(Request $request)
    {

        $self='add-employee-training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'employee'=>'required',
        ]);

        if($v->fails()){
            return redirect('training/employee-training')->withErrors($v->errors());
        }


        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/employee-training')->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }
        $training_from=date('Y-m-d',strtotime($request->training_from));
        $training_to=date('Y-m-d',strtotime($request->training_to));

        $emp_training=new EmployeeTraining();

        $emp_training->trainer=$request->trainer;
		$emp_training->trainingdetail=$request->trainingdetail;
        $emp_training->training_location=$request->training_location;
        $emp_training->training_from=$training_from;
        $emp_training->training_to=$training_to;
        $emp_training->description=$request->description;
        $emp_training->save();

        $emp_t_id = $emp_training->id;

        foreach ($employee as $e) {
            $assign = new TrainingMembers();
            $assign->training_id = $emp_t_id;
            $assign->emp_id = $e;
            $assign->save();
        }


        return redirect('training/view-applicant/'.$emp_t_id)->with(['message' => 'Çalışan Eğitimleri Başarılı Bir Şekilde Girildi'
        ]);

    }

    /* deleteEmployeeTraining  Function Start Here */
    public function deleteEmployeeTraining($id)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/employee-training')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }


        $self='employee-training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $emp_train=EmployeeTraining::find($id);

        if($emp_train){
            TrainingMembers::where('training_id',$id)->delete();
            $emp_train->delete();

            return redirect('training/employee-training')->with([
                'message'=> language_data('Employee training deleted successfully')
            ]);

        }else{
            return redirect('training/employee-training')->with([
                'message'=> language_data('Employee training info not found'),
                'message_important'=>true
            ]);
        }
    }

    /* viewEmployeeTraining  Function Start Here */
    public function viewEmployeeTraining($id)
    {
        $self='employee-training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $emp_train=EmployeeTraining::find($id);

        if($emp_train){
            $employee=Employee::where('user_name','!=','admin')->where('status','Active')->get();
            $trainers=Trainers::all();
            $train_members=TrainingMembers::where('training_id',$id)->get(['emp_id'])->toArray();
            $trainingdetails=TrainingDetails::all();


            return view('admin.view-employee-training',compact('emp_train','employee','trainers','train_members','trainingdetails'));

        }else{
            return redirect('training/employee-training')->with([
                'message'=> language_data('Employee training info not found'),
                'message_important'=>true
            ]);
        }
    }

    /* postEmployeeTrainingInfo  Function Start Here */
    public function postEmployeeTrainingInfo(Request $request)
    {

        $self='employee-training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $cmd=Input::get('cmd');
        $v=\Validator::make($request->all(),[
            'employee'=>'required','training_type'=>'required','training_subject'=>'required','training_nature'=>'required','training_title'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/view-employee-training/'.$cmd)->withErrors($v->errors());
        }


        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/view-employee-training/'.$cmd)->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }

        $emp_training=EmployeeTraining::find($cmd);

        if($emp_training){

            $training_from=date('Y-m-d',strtotime($request->training_from));
            $training_to=date('Y-m-d',strtotime($request->training_to));

            $emp_training->trainer=$request->trainer;
			$emp_training->trainingdetail=$request->trainingdetail;
            $emp_training->training_location=$request->training_location;
            $emp_training->training_from=$training_from;
            $emp_training->training_to=$training_to;
            $emp_training->description=$request->description;
            $emp_training->save();

            TrainingMembers::where('training_id',$cmd)->delete();

            foreach ($employee as $e) {
                $assign = new TrainingMembers();
                $assign->training_id = $cmd;
                $assign->emp_id = $e;
                $assign->save();
            }


            return redirect('training/employee-training')->with([
                'message' => language_data('Training info updated successfully')
            ]);
        }else{

            return redirect('training/employee-training')->with([
                'message' => language_data('Employee training info not found'),
                'message_important'=>true
            ]);
        }

    }

    /* trainingNeedsAssessment  Function Start Here */
    public function trainingNeedsAssessment()
    {
        $self='training-needs-assessment';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $tnassessment=TrainingNeedsAssessment::all();
        $employee=Employee::where('user_name','!=','admin')->where('status','Active')->get();
        $trainers=Trainers::all();
        $department=Department::all();
        return view('admin.training-needs-assessment',compact('tnassessment','employee','trainers','department'));
    }

    public function postNewTrainingNeedsAssessment(Request $request)
    {
        $self='add-training-needs-assessment';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'employee'=>'required','training_type'=>'required','training_subject'=>'required','training_nature'=>'required','training_title'=>'required','status'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/training-needs-assessment')->withErrors($v->errors());
        }

        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }


        $training_from=date('Y-m-d',strtotime($request->training_from));
        $training_to=date('Y-m-d',strtotime($request->training_to));

        $emp_training=new TrainingNeedsAssessment();
        $emp_training->department=$request->department;
        $emp_training->training_type=$request->training_type;
        $emp_training->training_subject=$request->training_subject;
        $emp_training->training_nature=$request->training_nature;
        $emp_training->title=$request->training_title;
        $emp_training->training_reason=$request->training_reason;
        $emp_training->trainer=$request->trainer;
        $emp_training->training_location=$request->training_location;
        $emp_training->training_cost=$request->training_cost;
        $emp_training->travel_cost=$request->travel_cost;
        $emp_training->training_from=$training_from;
        $emp_training->training_to=$training_to;
        $emp_training->status=$request->status;
        $emp_training->description=$request->description;
        $emp_training->save();

        $emp_t_id = $emp_training->id;

        foreach ($employee as $e) {
            $assign = new TrainingNeedsAssessmentMembers();
            $assign->training_id = $emp_t_id;
            $assign->emp_id = $e;
            $assign->save();
        }


        return redirect('training/training-needs-assessment')->with([
            'message' => language_data('Training needs assessment added successfully')
        ]);

    }

    public function deleteTrainingNeedsAssessment($id){

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }


        $self='training-needs-assessment';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $tnassessment=TrainingNeedsAssessment::find($id);

        if ($tnassessment){
            TrainingNeedsAssessmentMembers::where('training_id',$id)->delete();
            $tnassessment->delete();

            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Training needs assessment deleted successfully')
            ]);
        }else{
            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Training needs assessment info not found'),
                'message_important' => true
            ]);
        }
    }

    /* viewTrainingNeedsAssessment  Function Start Here */
    public function viewTrainingNeedsAssessment($id){

        $self='training-needs-assessment';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $tnassessment=TrainingNeedsAssessment::find($id);

        if ($tnassessment){
            $employee=Employee::where('user_name','!=','admin')->where('status','Active')->get();
            $trainers=Trainers::all();
            $department=Department::all();
            $train_members=TrainingNeedsAssessmentMembers::where('training_id',$id)->get(['emp_id'])->toArray();
            return view('admin.view-training-needs-assessment',compact('tnassessment','employee','trainers','department','train_members'));
        }else{
            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Training needs assessment info not found'),
                'message_important' => true
            ]);
        }
    }

    /* postTrainingNeedsAssessmentUpdate  Function Start Here */
    public function postTrainingNeedsAssessmentUpdate(Request $request){

        $self='training-needs-assessment';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $cmd=Input::get('cmd');
        $v=\Validator::make($request->all(),[
            'employee'=>'required','training_type'=>'required','training_subject'=>'required','training_nature'=>'required','training_title'=>'required','status'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/view-training-needs-assessment/'.$cmd)->withErrors($v->errors());
        }

        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/view-training-needs-assessment/'.$cmd)->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }

        $emp_training=TrainingNeedsAssessment::find($cmd);

        if ($emp_training){

            $training_from=date('Y-m-d',strtotime($request->training_from));
            $training_to=date('Y-m-d',strtotime($request->training_to));

            $emp_training->department=$request->department;
            $emp_training->training_type=$request->training_type;
            $emp_training->training_subject=$request->training_subject;
            $emp_training->training_nature=$request->training_nature;
            $emp_training->title=$request->training_title;
            $emp_training->training_reason=$request->training_reason;
            $emp_training->trainer=$request->trainer;
            $emp_training->training_location=$request->training_location;
            $emp_training->training_cost=$request->training_cost;
            $emp_training->travel_cost=$request->travel_cost;
            $emp_training->training_from=$training_from;
            $emp_training->training_to=$training_to;
            $emp_training->status=$request->status;
            $emp_training->description=$request->description;
            $emp_training->save();

            TrainingNeedsAssessmentMembers::where('training_id',$cmd)->delete();

            foreach ($employee as $e) {
                $assign = new TrainingNeedsAssessmentMembers();
                $assign->training_id = $cmd;
                $assign->emp_id = $e;
                $assign->save();
            }


            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Training needs assessment updated successfully')
            ]);

        }else{
            return redirect('training/training-needs-assessment')->with([
                'message' => language_data('Training needs assessment info not found'),
                'message_important' => true
            ]);
        }

    }

    /* trainingEvents  Function Start Here */
    public function trainingEvents(){

        $self='training-events';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_event=TrainingEvents::all();
        $employee=Employee::where('status','active')->where('user_name','!=','admin')->get();
        $trainers=Trainers::all();
        return view('admin.training-events',compact('training_event','employee','trainers'));
    }

    /* postNewTrainingEvent  Function Start Here */
    public function postNewTrainingEvent(Request $request){

        $self='add-training-events';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'employee'=>'required','trainer'=>'required','training_type'=>'required','training_subject'=>'required','training_nature'=>'required','training_title'=>'required','status'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/training-events')->withErrors($v->errors());
        }

        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/training-events')->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }

        $trainer = Input::get('trainer');
        if (count($trainer) == 0) {
            return redirect('training/training-events')->with([
                'message' => language_data('Trainer not assigned'),
                'message_important' => true
            ]);
        }

        $training_from=date('Y-m-d',strtotime($request->training_from));
        $training_to=date('Y-m-d',strtotime($request->training_to));

        $training_event=new TrainingEvents();
        $training_event->training_type=$request->training_type;
        $training_event->training_subject=$request->training_subject;
        $training_event->training_nature=$request->training_nature;
        $training_event->title=$request->training_title;
        $training_event->externals=$request->externals;
        $training_event->training_location=$request->training_location;
        $training_event->sponsored_by=$request->sponsored_by;
        $training_event->organized_by=$request->organized_by;
        $training_event->training_from=$training_from;
        $training_event->training_to=$training_to;
        $training_event->status=$request->status;
        $training_event->description=$request->description;
        $training_event->save();

        $emp_t_id = $training_event->id;

        foreach ($employee as $e) {
            $assign = new TrainingEventsEmployee();
            $assign->training_id = $emp_t_id;
            $assign->emp_id = $e;
            $assign->save();
        }

        foreach ($trainer as $t) {
            $assign = new TrainingEventsTrainers();
            $assign->training_id = $emp_t_id;
            $assign->trainer_id = $t;
            $assign->save();
        }

        return redirect('training/training-events')->with([
            'message' => language_data('Training event added successfully')
        ]);
    }

    /* deleteTrainingEvent  Function Start Here */
    public function deleteTrainingEvent($id)
    {

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/training-events')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='training-events';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_event=TrainingEvents::find($id);

        if ($training_event){
            TrainingEventsEmployee::where('training_id',$id)->delete();
            TrainingEventsTrainers::where('training_id',$id)->delete();

            $training_event->delete();

            return redirect('training/training-events')->with([
                'message' => language_data('Training event deleted successfully')
            ]);
        }else{
            return redirect('training/training-events')->with([
                'message' => language_data('Training event info not found'),
                'message_important'=>true
            ]);
        }
    }

    /* viewTrainingEvent  Function Start Here */
    public function viewTrainingEvent($id){

        $self='training-events';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_event=TrainingEvents::find($id);

        if ($training_event){
            $employee=Employee::where('status','active')->where('user_name','!=','admin')->get();
            $trainers=Trainers::all();
            $event_members=TrainingEventsEmployee::where('training_id',$id)->get(['emp_id'])->toArray();
            $event_trainers=TrainingEventsTrainers::where('training_id',$id)->get(['trainer_id'])->toArray();

            return view('admin.view-training-events',compact('training_event','employee','trainers','event_members','event_trainers'));
        }else{
            return redirect('training/training-events')->with([
                'message' => language_data('Training event info not found'),
                'message_important'=>true
            ]);
        }

    }


    /* postTrainingEventUpdate  Function Start Here */
    public function postTrainingEventUpdate(Request $request){

        $self='training-events';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $cmd=Input::get('cmd');

        $v=\Validator::make($request->all(),[
            'employee'=>'required','trainer'=>'required','training_type'=>'required','training_subject'=>'required','training_nature'=>'required','training_title'=>'required','status'=>'required'
        ]);

        if($v->fails()){
            return redirect('training/view-training-events/'.$cmd)->withErrors($v->errors());
        }

        $employee = Input::get('employee');
        if (count($employee) == 0) {
            return redirect('training/view-training-events/'.$cmd)->with([
                'message' => language_data('Employee not assigned'),
                'message_important' => true
            ]);
        }

        $trainer = Input::get('trainer');
        if (count($trainer) == 0) {
            return redirect('training/view-training-events/'.$cmd)->with([
                'message' => language_data('Trainer not assigned'),
                'message_important' => true
            ]);
        }

        $training_event=TrainingEvents::find($cmd);

        if ($training_event){

            $training_from=date('Y-m-d',strtotime($request->training_from));
            $training_to=date('Y-m-d',strtotime($request->training_to));

            $training_event->training_type=$request->training_type;
            $training_event->training_subject=$request->training_subject;
            $training_event->training_nature=$request->training_nature;
            $training_event->title=$request->training_title;
            $training_event->externals=$request->externals;
            $training_event->training_location=$request->training_location;
            $training_event->sponsored_by=$request->sponsored_by;
            $training_event->organized_by=$request->organized_by;
            $training_event->training_from=$training_from;
            $training_event->training_to=$training_to;
            $training_event->status=$request->status;
            $training_event->description=$request->description;
            $training_event->save();

            TrainingEventsEmployee::where('training_id',$cmd)->delete();
            TrainingEventsTrainers::where('training_id',$cmd)->delete();

            foreach ($employee as $e) {
                $assign = new TrainingEventsEmployee();
                $assign->training_id = $cmd;
                $assign->emp_id = $e;
                $assign->save();
            }

            foreach ($trainer as $t) {
                $assign = new TrainingEventsTrainers();
                $assign->training_id = $cmd;
                $assign->trainer_id = $t;
                $assign->save();
            }

            return redirect('training/training-events')->with([
                'message' => language_data('Training event updated successfully')
            ]);


        }else{

            return redirect('training/training-events')->with([
                'message' => language_data('Training event info not found'),
                'message_important'=>true
            ]);
        }

    }

    /* TrainingEvaluations  Function Start Here */
    public function TrainingEvaluations(){

        $self='training-evaluations';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_evaluation=TrainingEvaluations::all();

        $training=EmployeeTraining::all();

        return view('admin.training-evaluations',compact('training_evaluation','training'));

    }

    /* postTrainingEvaluations  Function Start Here */
    public function postTrainingEvaluations(Request $request){

        $self='training-evaluations';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'training_title'=>'required','description'=>'required'
        ]);

        if ($v->fails()){
            return redirect('training/evaluations')->withErrors($v->errors());
        }

        $training_evaluation=new TrainingEvaluations();
        $training_evaluation->training_id=$request->training_title;
        $training_evaluation->description=$request->description;

        $training_evaluation->save();

        return redirect('training/evaluations')->with([
            'message'=> language_data('Training evaluation completed')
        ]);

    }

    /* updateTrainingEvaluations  Function Start Here */
    public function updateTrainingEvaluations(Request $request){

        $self='training-evaluations';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $v=\Validator::make($request->all(),[
            'training_title'=>'required','description'=>'required'
        ]);

        if ($v->fails()){
            return redirect('training/evaluations')->withErrors($v->errors());
        }


        $training_evaluation=TrainingEvaluations::find($request->cmd);

        if ($training_evaluation){

            $training_evaluation->training_id=$request->training_title;
            $training_evaluation->description=$request->description;

            $training_evaluation->save();

            return redirect('training/evaluations')->with([
                'message'=> language_data('Training evaluation updated')
            ]);
        }else{
            return redirect('training/evaluations')->with([
                'message'=> language_data('Training evaluation info not found'),
                'message_important'=>true
            ]);
        }



    }

    /* deleteTrainingEvaluations  Function Start Here */
    public function deleteTrainingEvaluations($id){

        $appStage=app_config('AppStage');
        if($appStage=='Demo'){
            return redirect('training/evaluations')->with([
                'message' => language_data('This Option is Disable In Demo Mode'),
                'message_important'=>true
            ]);
        }

        $self='training-evaluations';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_evaluation=TrainingEvaluations::find($id);

        if ($training_evaluation){
            $training_evaluation->delete();

            return redirect('training/evaluations')->with([
                'message'=> language_data('Training evaluation deleted successfully')
            ]);
        }else{
            return redirect('training/evaluations')->with([
                'message'=> language_data('Training evaluation info not found'),
                'message_important'=>true
            ]);
        }

    }
	
public function viewTrainingApplicant($id)
    {
        $self='training-applicants';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }

        $trainingapplicants = TrainingMembers::where('training_id', '=', $id)->get();
	    $emp_training= EmployeeTraining::find($id);
        return view('admin.view-trainingapplication', compact('trainingapplicants','emp_training'));
    }
	
 /* setApplicantStatus  Function Start Here */
    public function setApplicantDetails(Request $request)
    {
        $self='training-applicants';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message' => language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }


        $training_id=Input::get('training_id');
        $cmd=Input::get('cmd');
        $training_applicant=TrainingMembers::find($cmd);

		if($training_applicant){
			
			$v=\Validator::make($request->all(),[

		]);
			 if($v->fails()){
            return redirect('training/view-applicant/'.$training_id)->withErrors($v->fails());
        }
		
		$training_memberrr = TrainingMembers::find($cmd)->emp_id;

			

		$employee_training_document_number = Input::get('employee_training_document_number');
		$employee_training_grade = Input::get('employee_training_grade');	
			$employee_training_document = Input::File('employee_training_document');

		if ($employee_training_document != '') {
				$destinationPath = public_path() . '/assets/employee_document/'.$training_memberrr.'/training_document/'.$training_id.'/';

                \File::delete($destinationPath.$training_applicant->employee_training_document);

                $employee_training_document_name = $employee_training_document->getClientOriginalName();
				Input::file('employee_training_document')->move($destinationPath, $employee_training_document_name);
		} else {
                $employee_training_document_name = $training_applicant->employee_training_document;

		}
			
			$training_applicant->employee_training_grade = $employee_training_grade;
            $training_applicant->employee_training_document_number = $employee_training_document_number;
			$training_applicant->employee_training_document = $employee_training_document_name;
            $training_applicant->save();

            return redirect('training/view-applicant/'.$training_id)->with([
                'message'=> 'Durum başarıyla güncellendi',
            ]);

        }else{
            return redirect('training/view-applicant/'.$training_id)->with([
                'message'=> 'Applicant not found',
                'message_important'=>true
            ]);
        }

    }
	
	 public function downloadTrainingDocument($id)
    {

        $self='training';
        if (\Auth::user()->user_name!=='admin'){
            $get_perm=permission::permitted($self);

            if ($get_perm=='access denied'){
                return redirect('permission-error')->with([
                    'message'=>language_data('You do not have permission to view this page'),
                    'message_important'=>true
                ]);
            }
        }
		 
		$training_id = TrainingMembers::find($id)->training_id;
		$training_memberrr = TrainingMembers::find($id)->emp_id;
		 
        $file = TrainingMembers::find($id)->employee_training_document;
        return response()->download(public_path('/assets/employee_document/'.$training_memberrr.'/training_document/'.$training_id.'/' . $file));
    }


}
