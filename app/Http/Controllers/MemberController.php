<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Member;
use App\MemberCategory;
use App\Transactions;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::with('membcat')->orderBy('full_name', 'asc')->get();
        $memberCat = MemberCategory::all();
        return view('admin.member.index', compact('members', 'memberCat'));
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
            'date_of_birth'  =>  'required|date',
            'gender'  =>  'required|in:pria,wanita',
            'full_name'  =>  'required',
            'member_category_id'  =>  'required|exists:member_categories,id',
            'phone'  =>  'required',
            'address'  =>  'required',
            'email'  =>  'required|unique:members,email',
        ]);

        $member = new Member();
        $member->date_of_birth = $request->date_of_birth;
        $member->gender = $request->gender;
        $member->full_name = $request->full_name;
        $member->member_category_id = $request->member_category_id;
        $member->phone  = $request->phone;
        $member->address  = $request->address;
        $member->email = $request->email;
        $barcode = str_replace("-","",$request->date_of_birth).substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'),1,3);
        $member->barcode = $barcode;
        $expired = date('Y-m-d', strtotime('+1 year'));
        $member->expired = $expired;
        $member->save();

        return redirect()->route('members.index');
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
        $request->validate([
            'date_of_birth'  =>  'required|date',
            'gender2'  =>  'required|in:pria,wanita',
            'full_name'  =>  'required',
            'member_category_id'  =>  'required|exists:member_categories,id',
            'phone'  =>  'required',
            'address'  =>  'required',
            'email'  =>  'required|unique:members,email,'.$id,
            'expired' => 'required|date'
        ]);

        // return response()->json($request);
        $member = Member::findOrFail($id);
        $member->date_of_birth = $request->date_of_birth;
        $member->gender = $request->gender2;
        $member->full_name = $request->full_name;
        $member->member_category_id = $request->member_category_id;
        $member->phone  = $request->phone;
        $member->address  = $request->address;
        $member->email = $request->email;
        $member->expired = $request->expired;
        $member->save();

        return redirect()->route('members.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $trx = Transactions::where('buyer', $id)->get();
        foreach($trx as $t){
          $t->buyer = 0;
          $t->save();
        }
        $member->delete();
        return redirect(route('members.index'));
    }
}
