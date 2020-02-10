<?php

namespace App\Http\Controllers\API;

use App\MemberCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MemberCategoryController extends Controller
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
            $memberCategories = MemberCategory::all();
        } else {
            $memberCategories = MemberCategory::limit($limit)
                                ->offset($offset)
                                ->get();
        }

        return response()->json($memberCategories);
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
            'name'  =>  'required'
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

        $category = new MemberCategory();
        $category->name = $request->name;
        $category->save();

        $success['status'] = 'success';
        $success['data'] = $category;
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
        $memberCat = MemberCategory::findOrFail($id);
        return response()->json($memberCat);
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
            'name'  =>  'required'
        ]);

        if ($validator->fails()) {
            $error['status'] = 'error';
            $error['message'] = $validator->errors();
            return response()->json($error, 400);
        }

        $category = MemberCategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        $success['status'] = 'success';
        $success['data'] = $category;
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
        $category = MemberCategory::findOrFail($id);
        $category->delete();
        $success['status'] = 'success deleted';
        $success['data'] = $category;
        return response()->json($success);
    }

    public function search(Request $request)
    {
        $limit = $request->limit ?? 10;
        $offset = $request->offset ?? 0;

      
        //# by keyword parameter keyword
        $keyword = $request->keyword;
      
        // query builder
        if ($limit == -1) {
            $memberCategories = DB::table('member_categories');
        } else {
            $memberCategories = MemberCategory::limit($limit)
                                ->offset($offset);
        }

        if($keyword) {
            $memberCategories->where('name',"like",'%' . $keyword . '%');
        }

        //# order parameter orderBy & direction
        $orderField = $request->orderBy;
        $orderDirection = $request->direction ?? 'ASC';

        if($orderField) {
            $memberCategories->orderBy($orderField, $orderDirection);
        }

        $memberCategories = $memberCategories->get();
        return response()->json($memberCategories);
    }
}
