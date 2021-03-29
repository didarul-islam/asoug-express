<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Validator;

class CountryController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Country = Country::latest()->get();
        return response()->json([
            'message' => 'Country All Data',
            'Country' => $Country
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
            'arabic_name'=>'required',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

            
        $name =$request->name;
        $arabic_name = $request->arabic_name;
    
        $Country = Country::create(array_merge(
            [
                 'name' => $name,
                 'arabic_name' => $arabic_name,
                
             ],
        ));
  
            return response()->json([
                'message' => 'Country successfully Created',
                'Country' => $Country
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
        $data['country'] = Country::find($id);

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
            'name'=>'required',
            'arabic_name'=>'required',
            
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        
        $name =$request->name;
        $arabic_name = $request->arabic_name;

        $result= Country::where('id', '=', $id)->update(['name' => $name, 'arabic_name' => $arabic_name]);
        
       
        if($result){
            return response()->json([
                'message' => 'Country successfully Update'
               
            ], 201);
        }else{
            return response()->json([
                'message' => 'Country Not successfully Update',
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
        $Country = Country::find($id);

        $result = $Country->delete();

        if($result){
            return response()->json([
                'message' => 'Country successfully Delete',
            ], 201);
        }else{
            return response()->json([
                'message' => 'Country Not successfully Deleted',
            ], 400);
        }
    }
}
