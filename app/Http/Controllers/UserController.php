<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
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
        $request->validate([
            'full_name'  =>  'required',
            'username'  =>  'required|unique:users,username',
            'user_role'  =>  'required',
            'email'  =>  'required|unique:users,email',
            'phone'  =>  'required',
            'address'  =>  'required',
            'avatar'  =>  'required', //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password'  =>  'required|confirmed',
        ]);
        // $fileName = str_replace("=","",base64_encode($request->username.time())) . '.' . request()->avatar->getClientOriginalExtension();

        // if(!$request->avatar->move(storage_path('app/public/user'), $fileName)){
        //     return array('error' => 'Gagal upload foto');
        // } else {
            $user = new User();
            $user->user_role = $request->user_role;
            $user->full_name = $request->full_name;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phone  = $request->phone;
            $user->address  = $request->address;
            $user->avatar = str_replace(url('').'/', '', $request->avatar); //"storage/user/".$fileName;;
            $user->password = bcrypt($request->password);
            // return response()->json($user);
            $user->save();
        // }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // $userPict = User::where("id","=",$id)->get()->first()->avatar;
        // // return response()->json($userPict);
        // if (!$request->avatar) {
        //     // return 'still';
        //     $request->validate([
        //         'full_name'  =>  'required',
        //         'username'  =>  'required|unique:users,username,'.$id,
        //         'email'  =>  'required|unique:users,email,'.$id,
        //         'phone'  =>  'required',
        //         'address'  =>  'required',
        //         'user_role' => 'required',
        //         'password'  =>  'confirmed',
        //     ]);
        // } else {
        //     // return 'changed';
            $request->validate([
                'full_name'  =>  'required',
                'username'  =>  'required|unique:users,username,'.$id,
                'email'  =>  'required|unique:users,email,'.$id,
                'phone'  =>  'required',
                'address'  =>  'required',
                'user_role' => 'required',
                'password'  =>  'confirmed',
                'avatar'  =>  'required' //|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
        //     $fileName = str_replace("=","",base64_encode($request->username.time())) . '.' . request()->avatar->getClientOriginalExtension();
        // }

        $user = User::findOrFail($id);
        $user->full_name = $request->full_name;
        $user->phone  = $request->phone;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->user_role = $request->user_role;
        if($request->password) $user->password = bcrypt($request->password);
        $user->avatar = str_replace(url('').'/', '', $request->avatar);
        // if($request->hasFile('avatar')){
        //     // return 'available file';
        //     if (is_file($user->avatar)) {
        //         try {
        //             unlink($userPict);
        //         } catch(\Exception $e) {

        //         }
        //     }
        //     $request->avatar->move(storage_path('app/public/user'), $fileName);
        //     $user->avatar = "storage/user/".$fileName;
        // }else {
        //     // return 'no file uploaded';
        //     $user->avatar = $userPict;
        // }
        $user->update();

        return 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // if (is_file($user->avatar)) {
        //     unlink($user->avatar);
        // }
        $user->delete();
        return redirect(route('users.index'));
    }
}
