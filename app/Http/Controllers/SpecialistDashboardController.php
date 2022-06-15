<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;

class SpecialistDashboardController extends Controller
{
    //
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $success = [];

        $success['patients']['total'] = Patient::count();
        $success['patients']['thisMonth'] = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        $success['patients']['thisWeek'] = Patient::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['patients']['today'] = Patient::where('created_at', '>=', Carbon::today())->get()->count();
      
        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }

    public function specialistDashboardPatientCount(Request $request)
    {
        $success = [];
        $id = $request->input('id');

        $success['patients']['total'] = Patient::where('specialist_agent_id', $id)->count();
        $success['patients']['thisMonth'] = Patient::where('specialist_agent_id', $id)->whereMonth('created_at', Carbon::now()->month)->count();
        $success['patients']['thisWeek'] = Patient::where('specialist_agent_id', $id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['patients']['today'] = Patient::where('specialist_agent_id', $id)->where('created_at', '>=', Carbon::today())->get()->count();
      
        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }
}
