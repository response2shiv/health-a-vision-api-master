<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TestBokking;
use App\Models\TestingCenter;
use Illuminate\Http\Request;

class TestBokkingController extends Controller
{
    public $successStatus = 200;
    public function index()
    {
        $user = TestBokking::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$user], $this-> successStatus);         
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $user = TestBokking::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    public function getBookingsByTestCenter(Request $request)
    {
        $id = $request->input('id');
         $comment = TestBokking::orderBy('created_at', 'desc')->where('testing_center_id', $id)->with('patient')->with('testpanel')->get();
        if($comment){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }

    public function getBookingsByPatientId(Request $request)
    {
        $id = $request->input('id');
         $comment = TestBokking::orderBy('created_at', 'desc')->where('patient_id', $id)->with('testpanel')->get();
        if($comment){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }

    public function edit(Request $request)
    {
        $input = $request->all();
        $record = TestBokking::find($input['id']);
        if($input['testing_center_id'] != $record['testing_center_id']){
            return response()->json(['fail'=>$record], $this-> successStatus);     
        }
        if(isset($input['paymentStatus'])){
            $record['paymentStatus'] = $input['paymentStatus'];
        }
        if(isset($input['testStatus'])){
            $record['testStatus'] = $input['testStatus'];
        }
        if(isset($input['file'])){
            $record['file'] = $input['file'];
            $this->getOnePatient($record,$record->patient_id);
        }
        if(isset($input['paymentMode'])){
            $record['paymentMode'] = $input['paymentMode'];
        }
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
    }

    
    public function getOnePatient($data,$patientId)
    {
        $record = Patient::find($patientId);
        $pathology = TestingCenter::find($data->testing_center_id);
        MailController::patientReport($data,$record, $pathology); 

        // return response()->json(['success'=>$record], $this-> successStatus);         
    }
    // public function getBookingsByUserId(Request $request)
    // {
    //     $id = $request->input('id');
    //     $patinetIds = Patient::select('id')->where('own_user_id', $id)->get();
    //    $comment = TestBokking::whereIn('patient_id',$patinetIds)
    //    ->orderBy('created_at', 'desc')
    //    ->with('testpanel')
    //    ->with('testingCenter')
    //    ->get();
    //     if($comment){
    //         return response()->json(['success'=>$comment], $this-> successStatus); 
    //     }else{
    //         return response()->json(['success'=>[]], $this-> successStatus); 
    //     }

    // }

    public function myBookings(Request $request)
    {
        $patientId = $request->input('id');
        //$patinetIds = Patient::select('id')->where('own_user_id', $patientId)->get();
       $comment = TestBokking::whereIn('patient_id',[$patientId])
       ->orderBy('created_at', 'desc')
       ->with('testpanel')
       ->with('testingCenter')
       ->get();
        if($comment){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }



}
