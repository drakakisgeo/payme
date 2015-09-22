<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\User;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::where('email', '!=', getenv('USER_EMAIL'))->get();

        return view('adcp.users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('adcp.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->input();
        $rules = [
          'name'  => 'required',
          'email' => 'required|email'
        ];
        $validation = Validator::make($input, $rules);
        if ($validation->passes()) {
            User::create([
              'name'     => $input['name'],
              'email'    => $input['email'],
              'password' => \Hash::make(str_random(12)),
              'description' => $input['description']
            ]);

            return redirect()->route('adcp.dashboard')->with('msg', 'User created');
        }else {
            return back()->withInput()->withErrors($validation->errors());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        return view('adcp.users.edit')->with('user', User::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     *
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->input();
        $rules = [
          'name'  => 'required',
          'email' => 'required|email'
        ];

        $validation = Validator::make($input, $rules);
        if ($validation->passes()) {
            $user = User::findOrFail($id);
            $user->update([
              'name'        => $input['name'],
              'email'       => $input['email'],
              'description' => $input['description']
            ]);

            return redirect()->route('adcp.dashboard')->with('msg', 'User updated');
        }else {
            return back()->withInput()->withErrors($validation->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        dd('destroy user');
    }
}
