<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\{Auth, DB, Route, Session, Hash};
use Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){
            $user = Auth::user();
            $success['status'] = 'success';
            $success['user_role'] = $user->user_role;
            $success['token'] =  $user->createToken('MyApp')-> accessToken;
            return response()->json($success);
        }
        else{
            return response()->json(['status'=>'error', 'message'=>'Terjadi Kesalahan'], 401);
        }
    }
  
    public function logout() {
        if (Auth::check()) {
            Auth::user()->token()->revoke();
            return response()->json(['success' =>'logout_success'],200); 
        }else{
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json($user);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
        if ($validator->fails()) {
                    return response()->json(['error'=>$validator->errors()], 401);
                }
        $input = $request->all();
                $input['password'] = bcrypt($input['password']);
                $user = User::create($input);
                $success['token'] =  $user->createToken('MyApp')-> accessToken;
                $success['name'] =  $user->name;
        return response()->json(['success'=>$success], $this-> successStatus);
    }

    public function index()
    {
        $user = User::all();
        return response()->json($user);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
