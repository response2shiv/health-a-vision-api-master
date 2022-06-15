<?php

namespace App\Http\Controllers;

use App\Models\PatientOwnReportsFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PatientOwnReportsFileController extends Controller
{
    public $successStatus = 200;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = $request->input('id');
        $entityType = $request->input('entityType');
        $record = PatientOwnReportsFile::orderBy('created_at', 'desc')
        ->where('entityType',$entityType)
        ->where('user_id', $id)
        ->where('folder_id', null)
        ->offset(0)
        ->limit(8)        
        ->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
        
    }

    public function folderList(Request $request)
    {
        $id = $request->input('id');
        $entityType = $request->input('entityType');
        $record = PatientOwnReportsFile::
        where('entityType',$entityType)
        ->where('user_id',$id)
        ->selectRaw(
        'year(created_at) year, 
        month(created_at) month, 
        monthname(created_at) monthName, 
        count(*) totalFiles')
        ->groupBy('year', 'month','monthName')
        ->orderBy('year', 'desc')
        ->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
    }

    public function fileList(Request $request)
    {
        $id = $request->input('id');
        $y = $request->input('y');
        $m = $request->input('m');
        $entityType = $request->input('entityType');
        $record = PatientOwnReportsFile::whereYear('created_at', '=', $y)
              ->whereMonth('created_at', '=', $m)
              ->where('entityType',$entityType)
              ->where('user_id', '=', $id)
              ->get();        
        return response()->json(['success'=>$record], $this-> successStatus);         
    }

    public function allFileList(Request $request)
    {
        $id = $request->input('id');
        $record = PatientOwnReportsFile::where('user_id', '=', $id)
              ->get();        
        return response()->json(['success'=>$record], $this-> successStatus);         
    }


    



    public function getByFolderId(Request $request)
    {
        $id = $request->input('id');
        $record = PatientOwnReportsFile::orderBy('created_at', 'desc')->where('folder_id', $id)->get();
        return response()->json(['success'=>$record], $this-> successStatus);         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $user = PatientOwnReportsFile::create($input);
        $user->save();
        return response()->json(['success'=>$user], $this-> successStatus); 
        
    }

    public function deleteReport (Request $request) {
        $id = $request->input('id');
        if(PatientOwnReportsFile::where('id', $id)->exists()) {
          $record = PatientOwnReportsFile::find($id);
          $record->delete();
  
          return response()->json([
            "message" => "Record deleted"
          ],$this-> successStatus);
        } else {
          return response()->json([
            "message" => "File not found"
          ], 404);
        }
      }




      
    public function getPatientUseFileStorage(Request $request)
    {
        $id = $request->input('id');
        //$entityType = $request->input('entityType');
        
    
    $users = DB::table('patient_own_reports_files')
                ->join('users', 'patient_own_reports_files.user_id', '=', 'users.id')
                ->select('user_id')
                ->where('user_id', $id)
                //->where('entityType',$entityType)
                ->sum('patient_own_reports_files.size');


            return response()->json(['use_storage'=>$users,'user_id'=>$id], $this-> successStatus);
   
        
         
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
     * @param  \App\Models\PatientOwnReportsFile  $patientOwnReportsFile
     * @return \Illuminate\Http\Response
     */
    public function show(PatientOwnReportsFile $patientOwnReportsFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PatientOwnReportsFile  $patientOwnReportsFile
     * @return \Illuminate\Http\Response
     */
    public function edit(PatientOwnReportsFile $patientOwnReportsFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PatientOwnReportsFile  $patientOwnReportsFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PatientOwnReportsFile $patientOwnReportsFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientOwnReportsFile  $patientOwnReportsFile
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientOwnReportsFile $patientOwnReportsFile)
    {
        //
    }
   
}
