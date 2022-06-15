<?php

namespace App\Http\Controllers;

use App\Models\PatientOwnReportsFolder;
use Illuminate\Http\Request;

class PatientOwnReportsFolderController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $record = PatientOwnReportsFolder::orderBy('created_at', 'desc')->where('user_id', $id)->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $user = PatientOwnReportsFolder::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientOwnReportsFolder  $patientOwnReportsFolder
     * @return \Illuminate\Http\Response
     */
    public function show(PatientOwnReportsFolder $patientOwnReportsFolder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientOwnReportsFolder  $patientOwnReportsFolder
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientOwnReportsFolder $patientOwnReportsFolder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientOwnReportsFolder  $patientOwnReportsFolder
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientOwnReportsFolder $patientOwnReportsFolder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientOwnReportsFolder  $patientOwnReportsFolder
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientOwnReportsFolder $patientOwnReportsFolder)
    {
        //
    }
}
