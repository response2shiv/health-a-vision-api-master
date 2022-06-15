<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\UserController;
use App\Models\MyHavIds;
use App\Models\Patient;
use App\Models\TestingCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $success = [];
        //$success['patients'] = Patient::count();
        $success['patients']['total'] = Patient::count();
        $success['patients']['thisMonth'] = Patient::whereMonth('created_at', Carbon::now()->month)->count();
        
        $success['testingCenters']['total'] = TestingCenter::count();
        $success['testingCenters']['thisMonth'] = TestingCenter::whereMonth('created_at', Carbon::now()->month)->count();
        
        $success['specialistAgents']['total'] = User::where('userRole','SPECIALIST_AGENT')->count();
        $success['specialistAgents']['thisMonth'] = User::whereMonth('created_at', Carbon::now()->month)->where('userRole','SPECIALIST_AGENT')->count();


        $success['individualsPatients']['total'] = Patient::where('specialist_agent_id', null)->where('testing_center_id',null)->count();
        $success['individualsPatients']['thisMonth'] = Patient::whereMonth('created_at', Carbon::now()->month)->where('specialist_agent_id', null)->where('testing_center_id',null)->count();

        return response()->json(['success'=>$success], $this-> successStatus); 
        
    }
}
