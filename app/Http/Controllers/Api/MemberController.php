<?php

namespace App\Http\Controllers\API;

use App\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;
      
        if ($limit == -1) {
            $members = Member::with('membcat')->get();
        } else {
            $members = Member::with('membcat')
                                ->limit($limit)
                                ->offset($offset)
                                ->get();
        }
      
        return response()->json($members);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'date_of_birth'  =>  'required|date',
            'gender'  =>  'required|in:pria,wanita',
            'full_name'  =>  'required',
            'member_category_id'  =>  'required|exists:member_categories,id',
            'phone'  =>  'required',
            'address'  =>  'required',
            'email'  =>  'required|unique:members,email',
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

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

        $success['status'] = 'success';
        $success['data'] = $member;
        return response()->json($success);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $member = Member::where('id',$id)->with('membcat')->get()->first();
        return response()->json($member);
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
        $validator = Validator::make($request->all(),[
            'date_of_birth'  =>  'required|date',
            'gender'  =>  'required|in:pria,wanita',
            'full_name'  =>  'required',
            'member_category_id'  =>  'required|exists:member_categories,id',
            'phone'  =>  'required',
            'address'  =>  'required',
            'email'  =>  'required|unique:members,email,'.$id,
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

        $member = Member::findOrFail($id);
        $member->date_of_birth = $request->date_of_birth;
        $member->gender = $request->gender;
        $member->full_name = $request->full_name;
        $member->member_category_id = $request->member_category_id;
        $member->phone  = $request->phone;
        $member->address  = $request->address;
        $member->email = $request->email;
        $member->save();

        $success['status'] = 'success';
        $success['data'] = $member;
        return response()->json($success);
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
        $member->delete();
        $success['status'] = 'success delete';
        $success['data'] = $member;
        return response()->json($success);
    }

    public function search(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

        // query builder
        if ($limit == -1) {
            $members = Member::with('membcat');
        } else {
            $members = Member::with('membcat')
                                ->limit($limit)
                                ->offset($offset);
        }

        //# by keyword parameter keyword
        $keyword = $request->keyword;
        if($keyword) {
            $members->where('full_name',"like",'%' . $keyword . '%');
        }

        // by category
        $barcode = $request->barcode;
        if($barcode) {
            $members->where('barcode',$barcode);
        }

        //# order parameter orderBy & direction
        $orderField = $request->orderBy;
        $orderDirection = $request->direction ?? 'ASC';

        if($orderField) {
            $members->orderBy($orderField, $orderDirection);
        }

        $members = $members->get();
        return response()->json($members);
    }
}
