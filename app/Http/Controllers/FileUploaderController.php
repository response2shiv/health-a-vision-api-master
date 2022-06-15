<?php

namespace App\Http\Controllers;

use App\Models\FileUploader;
use Illuminate\Http\Request;
use App\Models\TestPanel;
use Illuminate\Support\Facades\Storage;
use File;

class FileUploaderController extends Controller
{
    public $successStatus = 200;
    public function fileUploadPost(Request $request)
    {
        $ext = $request->file->extension();
        $fileName = time().'.'.$ext;  
        $path = $request->file->move(public_path('uploads'), $fileName);
        $success['fileType'] =  $this->getType($ext);
        $success['uploadedName'] =  $fileName; 
        $success['orignalName'] = $request->file->getClientOriginalName();; 
        $success['size'] = File::size($path);
        return response()->json(['success'=>$success], $this-> successStatus);   
   
    }    
    
    public function csvUploadPost(Request $request)
    {
        $ext = $request->file->extension();
        $fileName = time().'.csv';  
        $path = $request->file->move(public_path('uploads'), $fileName);
        $success['fileType'] =  $this->getType($ext);
        $success['uploadedName'] =  $fileName; 
        $success['orignalName'] = $request->file->getClientOriginalName();; 
        $success['size'] = File::size($path);
        // Valid File Extensions
        $valid_extension = array("csv");

        // 2MB in Bytes
        $maxFileSize = 2097152; 

        // Check file extension
        

          // Check file size
          // if($fileSize <= $maxFileSize){

              // File upload location
              // $location = 'uploads';

              // Upload file
              // $file->move($location,$filename);

              // Import CSV to Database
              $filepath = public_path('uploads/'.$fileName);
              // $success['path'] =  $request->input('user_id');
              // $filepath = $path;
              // Reading file
              $file = fopen($filepath,"r");

              $importData_arr = array();
              $i = 0;
              
              while (($filedata = fgetcsv($file, 1000, ",")) !== FALSE) {
                $num = count($filedata );
                // Skip first row (Remove below comment if you want to skip the first row)
                if($i == 0){
                    $i++;
                    continue; 
                }else{
                  for ($c=0; $c < $num; $c++) {
                    if(is_null($filedata [$c]) || empty($filedata [$c])){
                      $success['messageCode'] = 'EC005';
                      return response()->json(['success'=>$success], $this-> successStatus);             
                    }
                    $importData_arr[$i][] = $filedata [$c];
                  }
                }
                $i++;
              }
              fclose($file);
              
              foreach($importData_arr as $importData){
                $insertData['name']=$importData[0];
                $insertData['category']=$importData[1];
                $insertData['tests']=$importData[2];
                $insertData['ratelist']=$importData[3];
                $insertData['testing_center_id']=$request->input('user_id');
                $insertData['amount']=$importData[4];
                TestPanel::create($insertData);
              }

              // Session::flash('message','Import Successful.');
            /* }else{
              Session::flash('message','File too large. File must be less than 2MB.');
            } */
            // $success['uploadedName'] =  $fileName; 
        return response()->json(['success'=>$success], $this-> successStatus);   
   
    }    

    public function getFile(Request $request)
    {
      $fileName = $request->input('fileName');
      $path = public_path('uploads').'/'.$fileName;
      return response()->download($path);   
    }    
    
    private function getType($ext){
        $pdf = ['pdf'];
        $imageExtension = [
          'jpg',
          'jpeg',
          'png',
          'gif',
          'tiff',
          'psd',
          'eps',
          'ai',
          'indd',
          'raw',
          'bmp',
        ];
        $pptExtension = [
          'pptx',
          'pptm',
          'ppt',
          'xps',
          'potx',
          'potm',
          'pot',
          'thmx',
          'ppsx',
          'pps',
          'ppam',
          'ppa',
          'odp',
        ];
        $wordExtensions = [
          'doc',
          'dot',
          'wbk',
          'docx',
          'docm',
          'dotx',
          'dotm',
          'docb',
          'odt',
        ];
        $xlExtensions = [
          'xls',
          'xlt',
          'xlm',
          'xlsx',
          'xlsm',
          'xltx',
          'xltm',
          'xlsb',
          'xla',
          'xlam',
          'xll',
          'xlw',
          'ods',
        ];        
        $zipExtensions = [
          'zip',
          'rar',
          'tgz',
          '7z'
        ];        
        $ext = strtolower($ext);
        $type = 'TEXT';

        if (in_array($ext, $pdf)) {
            $type =  "PDF";
          } else if (in_array($ext, $imageExtension)) {
            $type =  "IMAGE";
          } else if (in_array($ext, $pptExtension)) {
            $type =  "PPT";
          } else if (in_array($ext, $wordExtensions)) {
            $type =  "WORD";
          } else if (in_array($ext, $xlExtensions)) {
            $type =  "XLSHEET";
          } else if (in_array($ext, $zipExtensions)) {
            $type =  "ZIP";
          } else {
            $type =  "OTHER";
          }

        return $type;
    }
    
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
     * @param  \App\Models\FileUploader  $fileUploader
     * @return \Illuminate\Http\Response
     */
    public function show(FileUploader $fileUploader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FileUploader  $fileUploader
     * @return \Illuminate\Http\Response
     */
    public function edit(FileUploader $fileUploader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FileUploader  $fileUploader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FileUploader $fileUploader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FileUploader  $fileUploader
     * @return \Illuminate\Http\Response
     */
    public function destroy(FileUploader $fileUploader)
    {
        //
    }
}
