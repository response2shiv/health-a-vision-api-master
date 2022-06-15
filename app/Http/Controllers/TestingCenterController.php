<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TestingCenter;
use App\Models\TestPanel;
use Illuminate\Http\Request;

class TestingcenterController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = TestingCenter::orderBy('created_at', 'desc')->get();;
        //$comment = TestingCenter::find(1)->patients;

        return response()->json(['success'=>$user], $this-> successStatus); 

    }

    // Test center Patients
    public function getPatients(Request $request)
    {
        $id = $request->input('id');

        $comment = Patient::orderBy('created_at', 'desc')->where('testing_center_id',$id)->get();
        return response()->json(['success'=>$comment], $this-> successStatus); 

        // $comment = TestingCenter::orderBy('created_at', 'desc')->find($id)->patients;
        // return response()->json(['success'=>$comment], $this-> successStatus); 

    }

    // Test center Patients
    public function getBookings(Request $request)
    {
        $id = $request->input('id');
        $comment = TestingCenter::orderBy('created_at', 'desc')->find($id);
        if(isset($comment)){
            $d = $comment->bookings;
            return response()->json(['success'=>$d], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }

    // Test Panels
    public function getTestPanels(Request $request)
    {
        $id = $request->input('id');
        $comment = TestPanel::orderBy('created_at', 'desc')->where('testing_center_id',$id)->get();        
        if(isset($comment)){
            return response()->json(['success'=>$comment], $this-> successStatus); 
        }else{
            return response()->json(['success'=>[]], $this-> successStatus); 
        }

    }

    // Test Users
    public function getUsers(Request $request)
    {
        $id = $request->input('id');
        $comment = TestingCenter::orderBy('created_at', 'desc')->find($id)->users;
        return response()->json(['success'=>$comment], $this-> successStatus); 

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $user = TestingCenter::create($input);
        $user['HAVTestCenterUniqueID'] = $this->generateUniqueId($user);
        $user['prefix'] = $this->generatePrefix($user);
        $user->save();
        $masterlist = TestPanelController::masterlist2();
        foreach ($masterlist as $value) {
            $d = array(
                'name' => $value->name, 
                'category' => $value->category,
                'ratelist' => $value->ratelist,
                'amount' => $user->amount,
                'testing_center_id' => $user->id,
            );
            TestPanel::create($d);
        }
        return response()->json(['success'=>$user], $this-> successStatus); 
    }

    private function generateUniqueId($user){
        $result = '';
        if($user->name !=null){
            $d = explode(" ",$user->name);
            foreach ($d as $key => $value) {
                $result = $result . (strtoupper(substr($value,0,1)));
            }
        }
        $result = $result . "-" .str_pad($user->id, 6, "0", STR_PAD_LEFT);
        return $result;
    }

    private function generatePrefix($user){
        $result = '';
        if($user->name !=null){
            $d = explode(" ",$user->name);
            foreach ($d as $key => $value) {
                $result = $result . (strtoupper(substr($value,0,1)));
            }
        }
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
     * @param  \App\Models\TestingCenter  $TestingCenter
     * @return \Illuminate\Http\Response
     */
    public function show(TestingCenter $TestingCenter)
    {
        //
    }

    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $record = TestingCenter::find($id);
        return response()->json(['success'=>$record], $this-> successStatus);         
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TestingCenter  $TestingCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $input = $request->all();
        $record = TestingCenter::find($input['id']);
        $record['name'] = $input['name'];
        $record['addressline1'] = $input['addressline1'];
        $record['addressline2'] = $input['addressline2'];
        $record['city'] = $input['city'];
        $record['state'] = $input['state'];
        $record['postalCode'] = $input['postalCode'];
        $record['country'] = $input['country'];
        $record['email'] = $input['email'];
        $record['phone'] = $input['phone'];
        $record['registrationNo'] = $input['registrationNo'];
        $record['license'] = $input['license'];
        $record->save();    
        return response()->json(['success'=>$record], $this-> successStatus); 
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TestingCenter  $TestingCenter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TestingCenter $TestingCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TestingCenter  $TestingCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(TestingCenter $TestingCenter)
    {
        //
    }
}
