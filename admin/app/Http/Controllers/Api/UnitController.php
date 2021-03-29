<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Validator;

class UnitController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Unit = Unit::latest()->get();
        return response()->json([
            'message' => 'Unit All Data',
            'Unit' => $Unit
        ], 201);
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


        $validator = Validator::make($request->all(), [
            'name'=>'required',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

            

        $name =$request->name;
       
        $Unit = Unit::create(array_merge(
            [ 'name' => $name],
        ));
  
            return response()->json([
                'message' => 'Unit successfully Created',
                'Unit' => $Unit
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Changed
        $data['unit'] = Unit::find($id);

        return response()->json($data, 200);
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
        $validator = Validator::make($request->all(), [
            'name'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        
        $name =$request->name;
        $arabic_name = $request->arabic_name;

        $result= Unit::where('id', '=', $id)->update(['name' => $name]);
        
       
        if($result){
            return response()->json([
                'message' => 'Unit successfully Update'
               
            ], 201);
        }else{
            return response()->json([
                'message' => 'Unit Not successfully Update',
            ], 400);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Unit = Unit::find($id);

        $result = $Unit->delete();

        if($result){
            return response()->json([
                'message' => 'Unit successfully Delete',
            ], 201);
        }else{
            return response()->json([
                'message' => 'Unit Not successfully Deleted',
            ], 400);
        }
    }
}
