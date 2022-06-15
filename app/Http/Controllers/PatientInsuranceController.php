<?php

namespace App\Http\Controllers;

use App\Models\PatientInsurance;
use Illuminate\Http\Request;

class PatientInsuranceController extends Controller
{
    public $successStatus = 200;
    public function index(Request $request)
    {
        $result = [];
        $userId = $request->input('userId');
        $result = PatientInsurance::where('user_id',$userId)->orderBy('created_at', 'desc')->with('inssuranceProvider')->get();
        if(isset($result)){
            return response()->json(['success'=>$result], $this-> successStatus);
        }else{
            return response()->json(['fail'=>[]], $this-> successStatus);  
        }
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $user = PatientInsurance::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus);
    }

    public function edit(Request $request)
    {
        $input = $request->all();
        $record = PatientInsurance::find($input['id']);
        
        if(isset($input['insurance_provider'])){
            $record['insurance_provider'] = $input['insurance_provider'];
        }
        if(isset($input['fromDate'])){
            $record['fromDate'] = $input['fromDate'];
        }
        if(isset($input['toDate'])){
            $record['toDate'] = $input['toDate'];
        }
        if(isset($input['policyNumber'])){
            $record['policyNumber'] = $input['policyNumber'];
        }
        if(isset($input['ma_id'])){
            $record['ma_id'] = $input['ma_id'];
        }
        if(isset($input['insuredName'])){
            $record['insuredName'] = $input['insuredName'];
        }
        if(isset($input['insuranceType'])){
            $record['insuranceType'] = $input['insuranceType'];
        }
        if(isset($input['nomineeName'])){
            $record['nomineeName'] = $input['nomineeName'];
        }
        if(isset($input['nomineeRelationship'])){
            $record['nomineeRelationship'] = $input['nomineeRelationship'];
        }
        if(isset($input['premiumDate'])){
            $record['premiumDate'] = $input['premiumDate'];
        }
        if(isset($input['dob'])){
            $record['dob'] = $input['dob'];
        }
        if(isset($input['inssurance_provider_id'])){
            $record['inssurance_provider_id'] = $input['inssurance_provider_id'];
        }

        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function getOne(Request $request){
        $id = $request->input('userId');
        $result = PatientInsurance::orderBy('created_at', 'desc')->with('inssuranceProvider')->where('user_id', $id)->first();
        if($result){
            return response()->json(['success'=>$result], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }
    }
}
