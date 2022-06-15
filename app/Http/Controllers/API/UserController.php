<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OTPController;
use App\Http\Controllers\PatientController;
use App\Models\MasterSubscriptionPackage;
use App\Models\otp;
use App\Models\Patient;
use App\Models\SubscriptionPayments;
use App\Models\TestingCenter;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Models\Help;

class UserController extends Controller
{
    public $successStatus = 200;
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function login()
    {
        if (Auth::attempt(['email' => request('email'), 'password' => request('password'), 'userRole' => request('userRole')])) {
            $user = Auth::user();
            if($user->isVarified){
                $success['token'] =  $user->createToken('MyApp')->accessToken;
                $success['info'] = $user;
                if(isset($user->testing_center_id)){
                    $success['pathalogyInfo'] = TestingCenter::find($user->testing_center_id); 
                    return response()->json(['success' => $success], $this->successStatus);
                }
                else if($user->userRole == 'DOCTOR'){
                    if($user->isRegistrationComplete){
                        return response()->json(['success' => $success], $this->successStatus);
                    }
                    else{
                        $error['messageCode'] = 'EC002';
                        return response()->json(['error' => $error], 200);  
                    }
                }
                else{
                    return response()->json(['success' => $success], $this->successStatus);
                }
            }else{
                $error['messageCode'] = 'EC002';
                return response()->json(['error' => $error], 200);                
            }
        } else {
            $error['messageCode'] = 'EC001';
            return response()->json(['error' => $error], 401);
        }
    }
    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'name' => 'required', 
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $plain_password = $input['password'];
        $input['password'] = bcrypt($input['password']);
        $recordUser = User::where('email', $input['email'])->first();        
        if(isset($recordUser)){
            if($recordUser->isRegistrationComplete){
                $success['messageCode'] = 'EC004';
                return response()->json(['success' => $success], $this->successStatus);
            }else{
                $recordUser->firstName = $input["firstName"] ;
                $recordUser->lastName = $input["lastName"] ;
                $recordUser->phone = $input["phone"];
                $recordUser->dob = $input["dob"];
                // if($recordUser->userRole == "DOCTOR"){
                //     $recordUser->isRegistrationComplete = false;
                // }
                if(isset($input["gender"])){
                    $recordUser->gender = $input["gender"];    
                }
                $recordUser->password = $input["password"];
                $recordUser->save();
                $success['token'] =  true;
                MailController::welcomeUserEmail($recordUser,$plain_password);
                $otpIndex = UserController::sendOTP($recordUser);
                $this->createFreePackage($recordUser->id);
                return response()->json(['success' => $success], $this->successStatus);
            }
        }else{
            $user = User::create($input);
            $user['prefix'] = $this->getPrefix($user);
            $user->save();
            $this->createPatientForUser($user);
            $this->createFreePackage($user->id);

            $success['token'] =  true;
            if($user->userRole == "TESTING_CENTER"){
                $user->isVarified = true;
                $user->save();
            }
            
            if($user->userRole == "TESTING_CENTER"){

            }
            else{
                MailController::welcomeUserEmail($user,$plain_password);
                $otpIndex = UserController::sendOTP($user);
                if($user->userRole === 'PATIENT'){
                    $this->createFreePackage($user->id);
                }
            }

            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    function createFreePackage($userId){
        $record = MasterSubscriptionPackage::where('packageKey','FREE')->first();
        if(isset($record)){
            $input["transactionId"] =  time().'-'.(round(microtime(true) * 1000));
            $input["status"]  = "Success";
            $input["user_id"] = $userId;
            $input["master_subscription_package_id"] = $record->id;
            $user = SubscriptionPayments::create($input);
            $user->save();
        }
    }

    private function createPatientForUser($user){
        if($user->userRole !="PATIENT"){
            return ;
        }
        $newPatient = [];
        $newPatient["firstName"] = $user->firstName;
        $newPatient["lastName"] = $user->lastName;
        $newPatient["gender"] = $user->gender;
        $newPatient["dob"] = $user->dob;
        $newPatient["email"] = $user->email;
        $newPatient["phone"] = $user->phone;
        $p = new PatientController();
        $p->indirectPatientCreate($newPatient,$user);
    }

    public function createIndirectUser($input){
        $digits = 5;
        $password  = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $input['password'] = bcrypt($password);
        if($this->isUserExist($input['email'])){
            return null;
        }
        $user = User::create($input);
        $user['prefix'] = $this->getPrefix($user);
        $user->save();
        MailController::welcomeUserEmail($user,$password);
        MailController::speclistPatientAccessEmail($user,$password);
        return $user;
    }

    public function invitePatient($patient,$input,$pathalogy){
        $recordUser = User::where('email', $input['email'])->first();        
        if(isset($recordUser)){
            MailController::informPatient($patient,$recordUser,$pathalogy);
            return $recordUser;
        }else{
            $digits = 5;
            $password  = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
            $input['password'] = bcrypt($password);
    
            $user = User::create($input);
            $user['prefix'] = $this->getPrefix($user);
            $user->save();
            MailController::invitePatient($patient,$user,$pathalogy);
            return $user;
        }
    }


    private function getPrefix($user)
    {
        $result = '';
        if ($user->firstName != null) {
            $result = $result . (strtoupper(substr($user->firstName, 0, 1)));
        }
        if ($user->lastName != null) {
            $result = $result . (strtoupper(substr($user->lastName, 0, 1)));
        }
        return $result;
    }

    static function sendOTP($user)
    {
        $input['email'] = $user->email;
        $input['verificationType'] = 'email';
        $digits = 5;
        $newOtp  = rand(pow(10, $digits - 1), pow(10, $digits) - 1);
        $input['otpCode'] = $newOtp;
        $user['otpCode'] = $input['otpCode'];
        $result = otp::create($input);
        $user['otpCode'] = $result['otpCode'];
        MailController::sendOTPEmail($user);
        return $result;
    }


    /** 
     * details api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }

    public function getUsesByRole(Request $request)
    {
        $id = $request->input('role');
        $record = User::orderBy('created_at', 'desc')->where('userRole', $id)->get();
        return response()->json(['success' => $record], $this->successStatus);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            //'name' => 'required', 
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $otpController = new OTPController();
        $result = $otpController->verifyOtp($input);
        if($result['verified']){
            $input['password'] = bcrypt($input['password']);
            $user = User::where('email', '=', $input)->first();
            $user->password = $input['password'];
            $user->save();
            $success['messageCode'] = 'SC001';
            return response()->json(['success' => $success], $this->successStatus);
        }else{
            $success['messageCode'] = 'EC003';
            return response()->json(['success' => $success], $this->successStatus);
        }
    }

    private function isUserExist($email){
        $user = User::where('email', $email)->first();        
        if(isset($user)){
            return true;
        }else{
            return false;
            // $success['messageCode'] = 'EC004';
            // return response()->json(['success' => $success], $this->successStatus);            
        }
    }

    function updateProfile(Request $request){
        $input = $request->all();
        $record = User::find($input['id']);
        if(isset($input['firstName'])){
            $record['firstName'] = $input['firstName'];
        }
        if(isset($input['lastName'])){
            $record['lastName'] = $input['lastName'];
        }
        if(isset($input['gender'])){
            $record['gender'] = $input['gender'];
        }
        if(isset($input['phone'])){
            $record['phone'] = $input['phone'];
        }
        if(isset($input['dob'])){
            $record['dob'] = $input['dob'];
        }

        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 

    }

    function updateAddress(Request $request){
        $input = $request->all();
        $record = User::find($input['id']);
        if(isset($input['addressline1'])){
            $record['addressline1'] = $input['addressline1'];
        }
        if(isset($input['addressline2'])){
            $record['addressline2'] = $input['addressline2'];
        }
        if(isset($input['city'])){
            $record['city'] = $input['city'];
        }
        if(isset($input['state'])){
            $record['state'] = $input['state'];
        }
        if(isset($input['postalCode'])){
            $record['postalCode'] = $input['postalCode'];
        }
        if(isset($input['country'])){
            $record['country'] = $input['country'];
        }
        if(isset($input['state_short_name'])){
            $record['state_short_name'] = $input['state_short_name'];
        }
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 

    }

    function getInvitedUserInfo(Request $request){
        $input = $request->all();
        $record = User::find($input['id']);
        if(isset($record)){
            if(!$record->isRegistrationComplete){
                $patient = Patient::orderBy('created_at', 'asc')->where('own_user_id', $record->id)->with('testingCenter')->first();
                if(isset($patient)){
                    $record->patient = $patient;
                }
                return response()->json(['success'=>$record], $this-> successStatus); 
            }else{
                return response()->json(['success'=>null], $this-> successStatus);         
            }
        }
        return response()->json(['success'=>null], $this-> successStatus); 
    }


    public function edit(Request $request)
    {
        $input = $request->all();
        $record = User::find($input['id']);
    
        $record->isRegistrationComplete = true;
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
    }



    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = User::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);         
    }


    public function getOneRecord(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        if (is_null($user)) {
                $error['messageCode'] = 'Not Record Found';
                return response()->json(['success' => $error], 200);  
       }
       else{
         return response()->json(['success'=>$user], $this-> successStatus);
       }

    }


    public function updatePassword(Request $request){
        $id = $request->input('id');
        $record = User::find($id);

        $pass = bcrypt($request->input('password'));
        $record->password = $pass;
        
        $record->save(); 
        $success['messageCode'] = 'SC001';
        return response()->json(['success'=>$success], $this-> successStatus);
    }



}
