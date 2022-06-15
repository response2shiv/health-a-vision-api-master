<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public $successStatus = 200;

    public static function test()
    {
        $params["id"] =  'TEST_MAIL';
        $params["info"]["data"]["firstName"] =  "vinayak";
        $params["info"]["data"]["lastName"] =  "mana";
        $params["info"]["receiver"]["email"] =  "vinayakb@anomaly.co.in";
        $params["info"]["sender"] =  "DEFAULT";
        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response], 200);  
    }

    public static function sendOTPEmail($user)
    {

        $params["id"] =  'OTP_MAIL';
        $to_name = $user->firstName.' '.$user->lastName;
        
        $params["info"]["data"]["name"] =  $to_name;
        // $params["info"]["data"]["lastName"] =  $user->lastName;
        $params["info"]["data"]["otpCode"] =  $user->otpCode;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  
        
        
        
        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name,'otpCode'=>$user->otpCode);
        // //$data = array('name'=>'Ogbonna Vitalis(sender_name)', 'body' => 'A test mail');
        // Mail::send('emails.otpmail', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('Health A Vision Verification OTP');
        // $message->from('no-reply@healthvision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function welcomeUserEmail($user,$password)
    {
        // $emailFile = '';
        if($user->userRole =='PATIENT'){
            // $emailFile = "emails.welcome-patient";
            $params["id"] =  'PATIENT_WELCOME';

        }
        if($user->userRole =='SPECIALIST_AGENT'){
            // $emailFile = "emails.welcome-specialist";
            $params["id"] =  'SPECIALIST_WELCOME';

        }

        $to_name = $user->firstName.' '.$user->lastName;
        
        $params["info"]["data"]["name"] = $to_name;
        $params["info"]["data"]["passcode"] = $password;
        $params["info"]["data"]["email"] =   $user->email;
        // $params["info"]["data"]["lastName"] =  $user->lastName;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  
        
        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name);
        // Mail::send($emailFile , $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('Welcome on Health A Vision');
        // $message->from('no-reply@healthavision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function speclistPatientAccessEmail($user,$passcode)
    {

        $params["id"] =  'SPECLIST_PATIENT_ACSESS';

        $to_name = $user->firstName.' '.$user->lastName;

        $params["info"]["data"]["name"] =  $to_name;
        // $params["info"]["data"]["lastName"] =  $user->lastName;
        $params["info"]["data"]["passcode"] =   $passcode;
        $params["info"]["data"]["email"] =   $user->email;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  

        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name,'passcode'=>$passcode,'email'=>$user->email);
        // Mail::send('emails.invite-specialist-patient', $data, function($message) use ($to_name, $to_email) {
        // $message->to($to_email, $to_name)
        // ->subject('Health A Vision Access');
        // $message->from('no-reply@healthavision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function invitePatient($patient,$user,$pathalogy)
    {

        $url =  env('UI_URL', 'https://www.healthavision.com/app/#/sign-up/');
        // $url =  env('UI_URL', 'https://health-a-vision.web.app/sign-up/');
        $url = $url.$user->id;

        $params["id"] =  'INVITE_PATIENT';
        $to_name = $user->firstName.' '.$user->lastName;

        $params["info"]["data"]["name"] = $to_name;
        // $params["info"]["data"]["lastName"] =  $user->lastName;
        $params["info"]["data"]["pathalogy"] =  $pathalogy;
        $params["info"]["data"]["patient"] =   $patient;
        $params["info"]["data"]["url"] =   $url;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  

        // $url =  env('UI_URL', 'https://www.healthavision.com/app/#/sign-up/');
        // $url = $url.$user->id;
        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name,'email'=>$user->email,'pathalogy'=>$pathalogy,'patient'=>$patient,'url'=>$url);
        // Mail::send('emails.invite-patient', $data, function($message) use ($to_name, $to_email,$pathalogy) {
        // $message->to($to_email, $to_name)
        // ->subject($pathalogy->name .'invited you at HealthAVision');
        // $message->from('no-reply@healthavision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function patientReport($patientReport,$patientData, $pathology)
    {

        $url =  env('UI_URL', 'https://www.healthavision.com/api/public/api/file/get?fileName=');
        $url = $url.$patientReport->file;

        $params["id"] =  'PATIENT_REPORT';

        $to_name = $patientData->firstName.' '.$patientData->lastName;
        $params["info"]["data"]["name"] = $to_name;
        $params["info"]["data"]["pathalogy"] =  $pathology;
        $params["info"]["data"]["url"] =   $url;

        $params["info"]["receiver"]["email"] =   $patientData->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  

        // $url =  env('UI_URL', 'https://www.healthavision.com/app/#/sign-up/');
        // $url = $url.$user->id;
        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name,'email'=>$user->email,'pathalogy'=>$pathalogy,'patient'=>$patient,'url'=>$url);
        // Mail::send('emails.invite-patient', $data, function($message) use ($to_name, $to_email,$pathalogy) {
        // $message->to($to_email, $to_name)
        // ->subject($pathalogy->name .'invited you at HealthAVision');
        // $message->from('no-reply@healthavision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function informPatient($patient,$user,$pathalogy)
    {

        $params["id"] =  'INFORM_PATIENT';
        $to_name = $user->firstName.' '.$user->lastName;

        $params["info"]["data"]["name"] =  $to_name;
        // $params["info"]["data"]["lastName"] =  $user->lastName;
        $params["info"]["data"]["pathalogy"] =  $pathalogy;
        $params["info"]["data"]["patient"] =   $patient;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);  

        // $to_name = $user->firstName.' '.$user->lastName;
        // $to_email = $user->email;
        // $data = array('name'=>$to_name,'email'=>$user->email,'pathalogy'=>$pathalogy,'patient'=>$patient);
        // Mail::send('emails.inform-patient', $data, function($message) use ($to_name, $to_email,$pathalogy) {
        // $message->to($to_email, $to_name)
        // ->subject($pathalogy->name .' added/modified your details. at HealthAVision');
        // $message->from('no-reply@healthavision.com','Health a Vision');
        // });
        // return response()->json(['success'=>[]],200);    
    }

    public static function helpSupportEmail($user)
    {

        $params["id"] =  'HELP_SUPPORT_MAIL';

        $to_name = $user->name;

        $params["info"]["data"]["name"] =  $to_name;
        $params["info"]["data"]["phone"] =   $user->phone;
        $params["info"]["data"]["email"] =   $user->email;
        $params["info"]["data"]["message"] =   $user->message;

        $params["info"]["receiver"]["email"] = 'support@healthavision.com';
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);    
    }

    public static function helpUserEmail($user)
    {

        $params["id"] =  'HELP_USER_MAIL';

        $to_name = $user->name;

        $params["info"]["data"]["name"] =  $to_name;
        $params["info"]["data"]["phone"] =   $user->phone;
        // $params["info"]["data"]["email"] =   $user->email;
        $params["info"]["data"]["message"] =   $user->message;

        $params["info"]["receiver"]["email"] =   $user->email;
        $params["info"]["sender"] =  "DEFAULT";

        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response],200);    
    }

    public function destroy(Patient $patient)
    {
    }

    public static function inssurancePremiumReminder($inssurance)
    {
        $params["id"] =  'INSURANCE_PREMIUM_REMINDER';
        $params["info"]["data"] =  $inssurance;
        $params["info"]["receiver"]["email"] =  $inssurance->user->email;
        $params["info"]["sender"] =  "DEFAULT";
        $make_call = MailController::loginCallAPI($params);
        $response = json_decode($make_call, true);
        return response()->json(['success'=>$response], 200);  
    }

    public static function patientEventReminder($record)
    {
        $params["id"] =  'PATIENT_EVENT_REMINDER';

        if($record->start){
            $to_name = $record->patient->firstName.' '.$record->patient->lastName;
            $timestamp = (strtotime($record->start));
            $date = date('d-m-Y', $timestamp);
            $time = date('H:i:s', $timestamp);
    
            $params["info"]["data"] =  $record;
            $params["info"]["data"]["name"] =  $to_name;
            $params["info"]["data"]["event"] =  $record->title;
            $params["info"]["data"]["date"] =  $date;
            $params["info"]["data"]["time"] =  $time;
            $params["info"]["receiver"]["email"] =  $record->patient->email;
            $params["info"]["sender"] =  "DEFAULT";
            $make_call = MailController::loginCallAPI($params);
            $response = json_decode($make_call, true);
            return response()->json(['success'=>$response], 200);  

        } elseif ($record->appointment_at) {

            $to_name = $record->patient->firstName.' '.$record->patient->lastName;
            $timestamp = (strtotime($record->appointment_at));
            $date = date('d-m-Y', $timestamp);
            $time = date('H:i:s', $timestamp);
    
            $params["info"]["data"] =  $record;
            $params["info"]["data"]["name"] =  $to_name;
            $params["info"]["data"]["event"] =  $record->testpanel->name;
            $params["info"]["data"]["date"] =  $date;
            $params["info"]["data"]["time"] =  $time;
            $params["info"]["receiver"]["email"] =  $record->patient->email;
            $params["info"]["sender"] =  "DEFAULT";
            $make_call = MailController::loginCallAPI($params);
            $response = json_decode($make_call, true);
            return response()->json(['success'=>$response], 200);  
        }
      
    }

    static function  loginCallAPI($data){
        $url = 'https://pinnaclecommunication.api.fusionloopsolution.com/login/auth/login'; 
        $credatials =  array(
            "username"        => 'healthvision',
            "password"        => 'Super@1234'
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($credatials));
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'APIKEY: 111111111111111111111',
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        $parsedData = json_decode($result, true);
        if(isset($parsedData['accessToken'])){
            $mailResponse = MailController::callAPI($data,$parsedData['accessToken']);
            return $mailResponse;
        }else{
            return $result;        
        }
     }

     static function callAPI($data,$accessToken){
        $url = 'https://pinnaclecommunication.api.fusionloopsolution.com/communication/send';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        // OPTIONS:
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
           'Authorization: Bearer '.$accessToken,
           'Content-Type: application/json',
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // EXECUTE:
        $result = curl_exec($curl);
        if(!$result){die("Connection Failure");}
        curl_close($curl);
        return $result;
    }


}
