<?php

namespace App\Http\Controllers;

use App\Models\Help;
use Illuminate\Http\Request;

class HelpController extends Controller
{
  
    public $successStatus = 200;

    public function create(Request $request)
    {
        $input = $request->all();
        $record = Help::create($input);
        MailController::helpSupportEmail($record);
        MailController::helpUserEmail($record);
        $record->save();
        return response()->json(['success'=>$record], $this-> successStatus); 
    }

    public function list()
    {
        $user = Help::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = Help::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);         
    }
}
