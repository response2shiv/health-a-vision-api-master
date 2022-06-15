<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPayments;
use Illuminate\Http\Request;

class SubscriptionPaymentsController extends Controller
{
    public $successStatus = 200;
    public function index(Request $request)
    {
        $result = SubscriptionPayments::orderBy('created_at', 'desc')->with('masterSubscriptionPackage')->with('user')->get();;
        if(isset($result)){
            return response()->json(['success'=>$result], $this-> successStatus);
        }else{
            return response()->json(['fail'=>[]], $this-> successStatus);  
        }
        
    }

    public function create(Request $request)
    {
        $input = $request->all();
        $user = SubscriptionPayments::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus);

    }

    public function edit(Request $request)
    {
        $input = $request->all();
        $record = SubscriptionPayments::find($input['id']);
        
        if(isset($input['packageKey'])){
            $record['packageKey'] = $input['packageKey'];
        }
        if(isset($input['displayName'])){
            $record['displayName'] = $input['displayName'];
        }
        if(isset($input['description'])){
            $record['description'] = $input['description'];
        }
        if(isset($input['storageLimit'])){
            $record['storageLimit'] = $input['storageLimit'];
        }
        if(isset($input['charges'])){
            $record['charges'] = $input['charges'];
        }
        if(isset($input['validityInDays'])){
            $record['validityInDays'] = $input['validityInDays'];
        }

        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 

    }

    public function getOne(Request $request){
        $id = $request->input('id');
        $result = SubscriptionPayments::find($id)->with('masterSubscriptionPackage')->with('user')->get();
        if($result){
            return response()->json(['success'=>$result], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }
    }

    public function getByUser(Request $request){
        $id = $request->input('id');
        $result = SubscriptionPayments::orderBy('created_at', 'desc')->where('user_id', $id)->with('masterSubscriptionPackage')->with('user')->first();
        if($result){
            return response()->json(['success'=>$result], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }
    }


}
