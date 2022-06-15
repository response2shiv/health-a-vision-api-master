<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\TestBokking;
use Carbon\Carbon;

class PathologyDashboardController extends Controller
{
    //
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success = [];

        $success['patients']['total'] = Patient::count();
        $success['patients']['thisMonth'] = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        $success['patients']['thisWeek'] = Patient::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['patients']['today'] = Patient::where('created_at', '>=', Carbon::today())->get()->count();
      
        $success['Bookings']['total'] = TestBokking::count();
        $success['Bookings']['thisMonth'] = TestBokking::whereMonth('created_at', Carbon::now()->month)->count();
        $success['Bookings']['thisWeek'] = TestBokking::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['Bookings']['today'] = TestBokking::where('created_at', '>=', Carbon::today())->get()->count();
        
        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }

    public function pathologyDashboardPatientCount(Request $request)
    {
        $success = [];
        $id = $request->input('id');

        $success['patients']['total'] = Patient::where('testing_center_id', $id)->count();
        $success['patients']['thisMonth'] = Patient::where('testing_center_id', $id)->whereMonth('created_at', Carbon::now()->month)->count();
        $success['patients']['thisWeek'] = Patient::where('testing_center_id', $id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['patients']['today'] = Patient::where('testing_center_id', $id)->where('created_at', '>=', Carbon::today())->get()->count();

        $success['Bookings']['total'] = TestBokking::where('testing_center_id', $id)->count();
        $success['Bookings']['thisMonth'] = TestBokking::where('testing_center_id', $id)->whereMonth('created_at', Carbon::now()->month)->count();
        $success['Bookings']['thisWeek'] = TestBokking::where('testing_center_id', $id)->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get()->count();
        $success['Bookings']['today'] = TestBokking::where('testing_center_id', $id)->where('created_at', '>=', Carbon::today())->get()->count();
      
        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }
}

