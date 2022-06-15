<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\UserController;
use App\Models\MyHavIds;
use App\Models\Patient;
use App\Models\TestingCenter;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Patient::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $patient = Patient::create($input);
        $patient->HAVPatientID = $this->generateUniqueId($patient);
        $newUserRow = [];
            $uc = new UserController();
            $udata['firstName'] = $input['firstName'];
            $udata['lastName'] = $input['lastName'];
            $udata['phone'] = $input['phone'];
            $udata['email'] = $input['email'];
            if(isset($input['referredBy'])){
                $udata['referredBy'] = $input['referredBy'];
            }
            if(isset($input['dob'])){
                $udata['dob'] = $input['dob'];
            }
            if(isset($input['addressline1'])){
                $udata['addressline1'] = $input['addressline1'];
            }
            if(isset($input['addressline2'])){
                $udata['addressline2'] = $input['addressline2'];
            }
            if(isset($input['city'])){
                $udata['city'] = $input['city'];
            }
            if(isset($input['country'])){
                $udata['country'] = $input['country'];
            }
            if(isset($input['postalCode'])){
                $udata['postalCode'] = $input['postalCode'];
            }
            if(isset($input['state'])){
                $udata['state'] = $input['state'];
            }
            if(isset($input['state_short_name'])){
                $udata['state_short_name'] = $input['state_short_name'];
            }
            $udata['status'] = 1;
            $udata['userRole'] = 'PATIENT';
        if(isset($patient->specialist_agent_id)){
            // $newUserRow = $uc->createIndirectUser($udata);
            // if(isset($newUserRow)){
            //     $patient->own_user_id = $newUserRow->id;
            // }
            $udata['isRegistrationComplete'] = false;
            $udata['isVarified'] = false;            
            $specialist = user::find($patient->specialist_agent_id);
            $newUserRow = $uc->invitePatient($patient,$udata,$specialist);
            if(isset($newUserRow)){
                $patient->own_user_id = $newUserRow->id;
            }        
        }                
        if(isset($patient->testing_center_id)){
            $udata['isRegistrationComplete'] = false;
            $udata['isVarified'] = false;            
            $pathalogy = TestingCenter::find($patient->testing_center_id);
            $newUserRow = $uc->invitePatient($patient,$udata,$pathalogy);
            if(isset($newUserRow)){
                $patient->own_user_id = $newUserRow->id;
            }        
        }
        
        $patient->save();
        return response()->json(['success'=>$patient], $this-> successStatus); 
    }

    public function indirectPatientCreate($input,$user)
    {
        $newPatient = Patient::create($input);
        $newPatient->HAVPatientID = $this->generateUniqueId($newPatient);
        $newPatient->own_user_id = $user->id;
        $newPatient->save();

        // $newRecord['patient_id'] = $newPatient->id;
        // $newRecord['user_id'] = $user->id;
        // $comment = MyHavIds::create($newRecord);
        // $comment->save();        

    }

    private function generateUniqueId($user){
        $currentCount = 1;
        $result = 'HAV';
        //$record = TestingCenter::find($user->testing_center_id);
        if(isset($user->testing_center_id)){
            $result = $result . "-PAT-";
        }else if(isset($user->specialist_agent_id)){
            $result = $result . "-SPL-";
        }else{
            $result = $result . "-IND-";
        }
        $currentCount=
        Patient::where('state_short_name',$user->state_short_name)
        ->count(); 
        $result = $result . date('my') . '-'.$user->state_short_name.str_pad($currentCount, 2, "0", STR_PAD_LEFT);
        return $result;
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
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = Patient::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);         
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $input = $request->all();
        $record = Patient::find($input['id']);
        if($input['testing_center_id'] != $record['testing_center_id']){
            return response()->json(['fail'=>$record], $this-> successStatus);     
        }

        $record['title'] = $input['title'];
        $record['firstName'] = $input['firstName'];
        $record['lastName'] = $input['lastName'];
        $record['gender'] = $input['gender'];
        $record['email'] = $input['email'];
        $record['phone'] =  $input['phone'];
        $record['dob'] = $input['dob'];
        $record['addressline1'] = $input['addressline1'];
        $record['addressline2'] = $input['addressline2'];
        $record['city'] =  $input['city'];
        $record['state'] = $input['state'];
        $record['postalCode'] = $input['postalCode'];
        $record['country'] = $input['country'];
        $record['state_short_name'] = $input['state_short_name'];
        $record['referredBy'] = $input['referredBy'];
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    public function patientBySpecialistSgent(Request $request)
    {
        $id = $request->input('id');
        // $comment = TestBokking::orderBy('created_at', 'desc')->where('testing_center_id', $id)->with('testingCenter')->with('patient')->with('testpanel')->get();
         $comment = Patient::orderBy('created_at', 'desc')->where('specialist_agent_id', $id)->get();
        if($comment){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }    

    public function individualList(Request $request)
    {
        //$id = $request->input('id');
        // $comment = TestBokking::orderBy('created_at', 'desc')->where('testing_center_id', $id)->with('testingCenter')->with('patient')->with('testpanel')->get();
         $comment = Patient::orderBy('created_at', 'desc')->where('specialist_agent_id', null)->where('testing_center_id',null)->get();
        if($comment){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }    
}
