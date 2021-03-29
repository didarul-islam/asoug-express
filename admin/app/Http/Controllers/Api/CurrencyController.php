<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Illuminate\Http\Request;
use Validator;

class CurrencyController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Currency = Currency::latest()->get();
        return response()->json([
            'message' => 'Currency All Data',
            'Currency' => $Currency
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
            'symbol'=>'required',
            'code'=>'required',
            'exchange_rate'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

            
        $name =$request->name;
        $symbol = $request->symbol;
        $code = $request->code;
        $exchange_rate = $request->exchange_rate;
    
        $Currency = Currency::create(array_merge(
            [
                 'name' => $name,
                 'symbol' => $symbol,
                 'code' => $code,
                 'exchange_rate' => $exchange_rate,
                
             ],
        ));
  
            return response()->json([
                'message' => 'Currency successfully Created',
                'Currency' => $Currency
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
        $data['currency'] = Currency::find($id);

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
            'symbol'=>'required',
            'code'=>'required',
            'exchange_rate'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        
        $name =$request->name;
        $symbol = $request->symbol;
        $code = $request->code;
        $exchange_rate = $request->exchange_rate;

        $result= Currency::where('id', '=', $id)->update(['name' => $name, 'symbol' => $symbol, 'code' => $code, 'exchange_rate' => $exchange_rate]);
        
       
        if($result){
            return response()->json([
                'message' => 'Currency successfully Update'
               
            ], 201);
        }else{
            return response()->json([
                'message' => 'Currency Not successfully Update',
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
        $Currency = Currency::find($id);

        $result = $Currency->delete();

        if($result){
            return response()->json([
                'message' => 'Currency successfully Delete',
            ], 201);
        }else{
            return response()->json([
                'message' => 'Currency Not successfully Deleted',
            ], 400);
        }
    }
}
