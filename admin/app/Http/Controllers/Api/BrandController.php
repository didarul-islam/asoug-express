<?php

namespace App\Http\Controllers\Api;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Str;
use Validator;

class BrandController extends Controller
{
         /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $BrandAll = Brand::with('category')->latest()->get();
        return response()->json([
            'message' => 'Brand All Data',
            'BrandAll' => $BrandAll
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
            'category_id'=>'required',
            'commision'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

            $slug=Str::slug($request->name);

            $next = 2;
            while (Brand::where('slug', '=', $slug)->first()) {
                $slug = $slug."-".$next;
                $next++;
            }

        $name =$request->name;
        $arabic_name = $request->arabic_name;
        $category_id =$request->category_id;
        $commision =$request->commision;

         if ($request->file('photo')){
            $photoPath =  $request->file('photo')->store('public');
            $photoName = (explode('/', $photoPath))[1];
            $host =$_SERVER['HTTP_HOST'];
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $location = $protocol . $host . "/public/storage/" . $photoName;
                    $Brand = Brand::create(array_merge(

                   [

                       'name' => $name,
                       'arabic_name' => $arabic_name,
                       'category_id' => $category_id,
                       'commision' => $commision,
                       'slug' => $slug,
                       'image' =>  $location,
                   ],

                ));
         }else{
              $Brand = Brand::create(array_merge(

                   [

                        'name' => $name,
                       'arabic_name' => $arabic_name,
                       'category_id' => $category_id,
                       'commision' => $commision,
                       'slug' => $slug
                      
                   ],

                ));
         }



            return response()->json([
                'message' => 'Brand successfully Store',
                'Brand' => $Brand
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
        $data['brand'] = Brand::find($id);
        $data['categories'] = Category::all();

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
            'category_id'=>'required',
            'commision'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $name =$request->name;
        $arabic_name = $request->arabic_name;
        $category_id =$request->category_id;
        $commision =$request->commision;
       
        if ($request->file('photo')){
            $photoPath =  $request->file('photo')->store('public');
            $photoName = (explode('/', $photoPath))[1];
            $host =$_SERVER['HTTP_HOST'];
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $location = $protocol . $host . "/public/storage/" . $photoName;
             $result= Brand::where('id', '=', $id)->update(['name' => $name, 'arabic_name' => $arabic_name, 'category_id' => $category_id,'commision' => $commision,'image' => $location]);
        }else{
             $result= Brand::where('id', '=', $id)->update(['name' => $name, 'arabic_name' => $arabic_name, 'category_id' => $category_id,'commision' => $commision]);
        }
       

        if($result){
            return response()->json([
                'message' => 'Brand successfully Update'
               
            ], 201);
        }else{
            return response()->json([
                'message' => 'Brand Not successfully Update',
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
        $Brand = Brand::find($id);

        $result = $Brand->delete();

        if($result){
            return response()->json([
                'message' => 'Brand successfully Delete',
            ], 201);
        }else{
            return response()->json([
                'message' => 'Brand Not successfully Delete',
            ], 400);
        }
    }
}
