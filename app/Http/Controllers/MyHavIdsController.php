<?php

namespace App\Http\Controllers;

use App\Models\MyHavIds;
use App\Models\Patient;
use Illuminate\Http\Request;

class MyHavIdsController extends Controller
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
        $record = Patient::orderBy('created_at', 'asc')->where('own_user_id', $id)->with('testingCenter')->get();
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
        $patient = Patient::where('HAVPatientID', $input['havId'])->first();
        if(isset($patient)){
            $patient->own_user_id = $input['userId'];
            $patient->save();
            return response()->json(['success'=>$patient], $this-> successStatus);             
        }else{
            return response()->json(['fail'=>[]], $this-> successStatus);             
        }
        // if(count($patient) > 0){
        //     $d = $patient[0];
        //     $isExists = MyHavIds::where('patient_id', $d->id)->where('user_id', $input['userId'])->get();
        //     if(count($isExists) > 0){
        //         return response()->json(['fail'=>[]], $this-> successStatus); 
        //     }else{                
        //         $newRecord['patient_id'] = $d->id;
        //         $newRecord['user_id'] = $input['userId'];
        
        //         $comment = MyHavIds::create($newRecord);
        //         $comment->save();        
        //         return response()->json(['success'=>$comment], $this-> successStatus); 
        //     }
        // }else{
        //     return response()->json(['fail'=>[]], $this-> successStatus); 
        // }
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
     * @param  \App\Models\MyHavIds  $myHavIds
     * @return \Illuminate\Http\Response
     */
    public function show(MyHavIds $myHavIds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MyHavIds  $myHavIds
     * @return \Illuminate\Http\Response
     */
    public function edit(MyHavIds $myHavIds)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MyHavIds  $myHavIds
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyHavIds $myHavIds)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MyHavIds  $myHavIds
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyHavIds $myHavIds)
    {
        //
    }
}
