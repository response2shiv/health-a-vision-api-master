<?php

namespace App\Http\Controllers;

use App\Models\TestPanel;
use Illuminate\Http\Request;

class TestPanelController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = TestPanel::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$user], $this-> successStatus);         
    }

    public function masterlist()
    {
        $user = TestPanel::orderBy('created_at', 'desc')->where('testing_center_id', null)->get();;
        return response()->json(['success'=>$user], $this-> successStatus);         
    }
    
    public static function masterlist2()
    {
        $user = TestPanel::orderBy('created_at', 'desc')->where('testing_center_id', null)->get();;
        return $user;
        //return response()->json(['success'=>$user], 200);         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $user = TestPanel::create($input);
        return response()->json(['success'=>$input], $this-> successStatus); 
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TestPanel  $testPanel
     * @return \Illuminate\Http\Response
     */
    public function show(TestPanel $testPanel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestPanel  $testPanel
     * @return \Illuminate\Http\Response
     */
    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = TestPanel::find($id);
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function edit(Request $request)
    {
        $input = $request->all();
        $record = TestPanel::find($input['id']);
        if($input['testing_center_id'] != $record['testing_center_id']){
            return response()->json(['fail'=>$record], $this-> successStatus);     
        }
        $record['name'] = $input['name'];
        $record['category'] = $input['category'];
        $record['tests'] = $input['tests'];
        $record['ratelist'] = $input['ratelist'];
        $record['amount'] = $input['amount'];
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestPanel  $testPanel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestPanel $testPanel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestPanel  $testPanel
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestPanel $testPanel)
    {
        //
    }
}
