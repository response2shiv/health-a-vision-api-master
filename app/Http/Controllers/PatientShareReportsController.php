<?php

namespace App\Http\Controllers;

use App\Models\PatientShareReports;
use Illuminate\Http\Request;

class PatientShareReportsController extends Controller
{
    public $successStatus = 200;
   
    public function create(Request $request)
    {
        $input = $request->all();
        $record = PatientShareReports::create($input);
        $record->save();
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function getReports(Request $request)
    {
        $doctor_id = $request->input('id');

        $record = PatientShareReports::orderBy('created_at', 'desc')
        ->where('doctor_id', $doctor_id)
        ->with('ownReport')->with('ownReport.user')
        ->with('testBook')->with('testBook.patient')
        ->with('doctor')
        ->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
        
    }
}
