<?php

namespace App\Http\Controllers;

use App\Payment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rhumsaa\Uuid\Uuid;

class AdminPaymentsController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $users = \App\User::lists('name','id');
        $users =  ['null'=>'--Select--'] + $users->toArray();
        return view('adcp.payments.create')->with('users',$users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $input = $request->except('_token');
        $input['amount'] = str_replace(',','.',$input['amount']);
        $input['code'] = Uuid::uuid4();

        $rules = [
            'amount'=>'required|numeric',
            'description'=>'required'
        ];

        $validation = \Validator::make($input,$rules);
        if($validation->passes()){
            Payment::create($input);
            return redirect(route('adcp.dashboard'));
        }else{
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $payment = Payment::find($id);
        return view('adcp.payments.show')->with('payment',$payment);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $payment = Payment::find($id);
        return view('adcp.payments.edit')->with('payment',$payment);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $input = $request->except('_token');
        $input['amount'] = str_replace(',','.',$input['amount']);

        $rules = [
          'amount'=>'required|numeric',
          'description'=>'required',
          'active'=>'required|boolean'
        ];

        $validation = \Validator::make($request->input(),$rules);
        if($validation->passes()){
            $payment->update($input);
            return redirect(route('adcp.dashboard'));
        }else{
            return redirect()->back()->withInput()->withErrors($validation->errors());
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $payment = Payment::where('id',$id)->where('paid',0)->firstOrFail();
        $payment->delete();
        return redirect(route('adcp.dashboard'))->with('msg','Deleted!');
    }
}
