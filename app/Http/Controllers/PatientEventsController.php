<?php

namespace App\Http\Controllers;

use App\Models\PatientEvents;
use App\Models\TestBokking;
use Illuminate\Http\Request;

class PatientEventsController extends Controller
{
   
    public $successStatus = 200;
   
    public function create(Request $request)
    {
        $input = $request->all();
        $record = PatientEvents::create($input);
        $record->save();
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function getEvents(Request $request)
    {
        $patient_id = $request->input('id');

        $record['patients'] = PatientEvents::orderBy('created_at', 'desc')->where('patient_id', $patient_id)->get(['title', 'start','end']);
        $record['testBookings'] = TestBokking::orderBy('created_at', 'desc')->where('patient_id', $patient_id)->with('testpanel')->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
        
    }
   
}
