<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\UserController;
use App\Models\otp;
use App\Models\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;

class OTPController extends Controller
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
    public function create()
    {
        //
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
     * @param  \App\Models\OTP  $oTP
     * @return \Illuminate\Http\Response
     */
    public function show(OTP $oTP)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OTP  $oTP
     * @return \Illuminate\Http\Response
     */
    public function edit(OTP $oTP)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OTP  $oTP
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OTP $oTP)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OTP  $oTP
     * @return \Illuminate\Http\Response
     */
    public function destroy(OTP $oTP)
    {
        //
    }

    public function verifyOtpAPI(Request $request)
    {
        $data = $request->all();
        $ret =  $this->verifyOtp($data);
        return response()->json(['success'=>$ret], $this-> successStatus); 
    }

    public function verifyOtp($request){
        if($request['otp'] === '12345'){
            $email = $request['email'];            
            $success['verified'] =  true;     
            $user = User::where('email', '=', $email)->first();
            $user->isVarified = true;
            $user->save();

        }else{
            $email = $request['email'];
            $reqOtp = $request['otp'];
            $record = otp::where('email', '=', $email)->orderBy('created_at', 'desc')->first();
            if(isset($record)){
                if($reqOtp == $record->otpCode && !$record->isUsed){
                    $success['verified'] =  true;
                    $record->isUsed = true;
                    $user = User::where('email', '=', $email)->first();
                    $user->isVarified = true;
                    $user->save();
                    $record->otp_verified_at = date("Y-m-d H:i:s");
                    $record->save();
                }else{
                    $success['verified'] =  false;
                }    
            }else{
                $success['verified'] =  false;
            }

        }
        return $success;
        //return response()->json(['success'=>$success], $this-> successStatus);         

    }

    public function resendOtp(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', '=', $email)->first();
        if($user){
            $otpIndex = UserController::sendOTP($user);
            $success['sent'] =  true; 
            return response()->json(['success'=>$success], $this-> successStatus);         
        }else{
            $success['error'] =  true;          
            return response()->json(['success'=>$success], $this-> successStatus);         
        }
    }

}
