<?php

namespace App\Http\Controllers;

use App\Models\LoginActivity;
use Illuminate\Http\Request;

class LoginActivityController extends Controller
{

    public $successStatus = 200;

    public function create(Request $request)
    {
        $input = $request->all();
        $record = LoginActivity::create($input);
        $record->save();
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    public function list(Request $request)
    {
        $user_id = $request->input('id');

        $record = LoginActivity::orderBy('created_at', 'desc')->where('user_id', $user_id)->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
        
    }
}
