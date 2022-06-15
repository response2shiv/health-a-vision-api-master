<?php

namespace App\Http\Controllers;

use App\Models\PaymentDetails;
use Illuminate\Http\Request;

class PaymentDetailsController extends Controller
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
    public function create(Request $request)
    {
        $input = $request->all();
        $subscription = PaymentDetails::create($input);
            
        $subscription->save();
        return response()->json(['success'=>$subscription], $this-> successStatus); 
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

    public function getPatientDetails(Request $request)
    {
        $id = $request->input('id');
        $subscription = PaymentDetails::where('patient_id' ,'=' ,$id)->get();
        return response()->json(['success'=>$subscription], $this-> successStatus);                
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentDetails $paymentDetails)
    {
        $details = PaymentDetails::orderBy('created_at', 'desc')->get();;
        return response()->json(['success'=>$details], $this-> successStatus); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentDetails $paymentDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentDetails $paymentDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentDetails  $paymentDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentDetails $paymentDetails)
    {
        //
    }
}
