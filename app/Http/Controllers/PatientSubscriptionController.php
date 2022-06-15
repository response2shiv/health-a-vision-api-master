<?php

namespace App\Http\Controllers;

use App\Models\PatientSubscription;
use Illuminate\Http\Request;

class PatientSubscriptionController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $subscription = PatientSubscription::create($input);
            
        $subscription->save();
        return response()->json(['success'=>$subscription], $this-> successStatus); 
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
     * @param  \App\Models\PatientSubscription  $patientSubscription
     * @return \Illuminate\Http\Response
     */
    public function show(PatientSubscription $patientSubscription)
    {
        //
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $subscription = PatientSubscription::where('patient_id' ,'=' ,$id)->get();
        return response()->json(['success'=>$subscription], $this-> successStatus);                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientSubscription  $patientSubscription
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientSubscription $patientSubscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientSubscription  $patientSubscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientSubscription $patientSubscription)
    {
        $input = $request->all();
        $record = PatientSubscription::find($input['id']);

        $record['package_id'] = $input['package_id'];

        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientSubscription  $patientSubscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientSubscription $patientSubscription)
    {
        //
    }
}
