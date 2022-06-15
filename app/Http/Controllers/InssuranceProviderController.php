<?php

namespace App\Http\Controllers;

use App\Models\InssuranceProvider;
use Illuminate\Http\Request;

class InssuranceProviderController extends Controller
{
    public $successStatus=200;

    public function index()
    {
        $user = InssuranceProvider::orderBy('name', 'asc')->get();;
        return response()->json(['success'=>$user], $this-> successStatus);         
        
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $user = InssuranceProvider::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    public function edit(Request $request)
    {
        $input = $request->all();
        $record = InssuranceProvider::find($input['id']);
        if(isset($input['name'])){
            $record['name'] = $input['name'];
        }
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = InssuranceProvider::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);                
    }
}
