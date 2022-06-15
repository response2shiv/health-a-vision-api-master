<?php

namespace App\Http\Controllers;

use App\Models\PatientPackage;
use Illuminate\Http\Request;

class PatientPackageController extends Controller
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
        $package = PatientPackage::create($input);
            
        $package->save();
        return response()->json(['success'=>$package], $this-> successStatus); 
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
     * @param  \App\Models\PatientPackage  $patientPackage
     * @return \Illuminate\Http\Response
     */
    public function show(PatientPackage $patientPackage)
    {
        $package = PatientPackage::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$package], $this-> successStatus); 
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = PatientPackage::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientPackage  $patientPackage
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientPackage  $patientPackage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientPackage $patientPackage)
    {
        $input = $request->all();
        $record = PatientPackage::find($input['id']);

        $record['name'] = $input['name'];
        $record['size'] = $input['size'];
        $record['validity'] = $input['validity'];
        $record['amount'] = $input['amount'];
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientPackage  $patientPackage
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientPackage $patientPackage)
    {
        //
    }
}
