<?php

namespace App\Http\Controllers;

use App\Models\MyHavIds;
use App\Models\Patient;
use App\Models\PatientVitals;
use Illuminate\Http\Request;

class PatientVitalsController extends Controller
{

    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $result = [];
        $userId = $request->input('userId');
        $patinetIds = [];
        if(isset($userId)){
            $patinetIds = Patient::select('id')->where('own_user_id', $userId)->get();
        }else{
            $patientId = $request->input('patientId');
            $patient = Patient::find($patientId);
            if(isset($patient)){
                if(isset($patient->own_user_id)){
                    $patinetIds = Patient::select('id')->where('own_user_id', $patient->own_user_id)->get();
                }else{
                    $patinetIds[0]['id'] = $patient->id;
                }
            }else{
                $patinetIds = [];
            }
        }

        $result = PatientVitals::whereIn('patient_id',$patinetIds)->orderBy('created_at', 'desc')->get();
        if(isset($result)){
            if(isset($result[0])){
                if(isset($result[1])){
                    if(isset($result['weight'])){
                        $result[0]['weightDiff'] = $result[0]->weight - $result[1]->weight;
                    }
                    if(isset($result['heartRate'])){
                        $result[0]['heartRateDiff'] = $result[0]->heartRate - $result[1]->heartRate;
                    }
                    if(isset($result['bloodPressure'])){
                        $result[0]['bloodPrssureDiff'] = $result[0]->bloodPressure - $result[1]->bloodPressure;
                    }
                }
                return response()->json(['success'=>$result[0]], $this-> successStatus);  
            }else{
                $result['weightDiff'] = 0;
                return response()->json(['success'=>$result], $this-> successStatus);                      
            }
        }else{
            return response()->json(['fail'=>[]], $this-> successStatus);  
        }
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $myhavIds = '';
        if(isset($input['user_id'])){
            $myhavIds = Patient::
            where('own_user_id', $input['user_id'])
            ->offset(0)->take(1)
            ->get();
            //return response()->json(['success'=>$myhavIds], $this-> successStatus); 
            if(isset($myhavIds)){
                if(isset($myhavIds[0])){
                    $input['patient_id'] = $myhavIds[0]->id;
                    $user = PatientVitals::create($input);
                    $user->save();
                    return response()->json(['success'=>$user], $this-> successStatus); 
                }else{
                    return response()->json(['fail'=>[]], $this-> successStatus);                      
                }
            }else{
                return response()->json(['fail'=>[]], $this-> successStatus);                
            }
        }else{
            $user = PatientVitals::create($input);
            $user->save();
            return response()->json(['success'=>$user], $this-> successStatus); 
        }
    }

    public function vitalsHistory(Request $request)
    {
        $id = $request->input('id');
        $data = PatientVitals::orderBy('created_at', 'desc')->where('patient_id', $id)->get();;
        return response()->json(['success'=>$data], $this-> successStatus);         
    }
}
