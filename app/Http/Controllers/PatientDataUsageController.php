<?php

namespace App\Http\Controllers;

use App\Models\PatientOwnReportsFile;
use Illuminate\Http\Request;

class PatientDataUsageController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataUsage(Request $request)
    {
        $success = [];

        $id = $request->input('id');
        $dataUsage = PatientOwnReportsFile::where('user_id' ,'=' ,$id)->sum('size');

        $success['dataUsage'] = $dataUsage;
        
        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }
}
