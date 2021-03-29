<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class CategoryController extends Controller
{
      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $CategoryAll = Category::with('parent')->latest()->get();
        return response()->json([
            'message' => 'Category All Data',
            'CategoryAll' => $CategoryAll
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
            'parent_id'=>'required',
            'commision'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

            $slug=Str::slug($request->name);

            $next = 2;
            while (Category::where('slug', '=', $slug)->first()) {
                $slug = $slug."-".$next;
                $next++;
            }

        $name =$request->name;
        $arabic_name = $request->arabic_name;
        $parent_id =$request->parent_id;
        $commision =$request->commision;

         if ($request->file('photo')){
            $photoPath =  $request->file('photo')->store('public');
            $photoName = (explode('/', $photoPath))[1];
            $host =$_SERVER['HTTP_HOST'];
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $location = $protocol . $host . "/public/storage/" . $photoName;
                    $Category = Category::create(array_merge(

                   [

                       'name' => $name,
                       'arabic_name' => $arabic_name,
                       'parent_id' => $parent_id,
                       'commision' => $commision,
                       'slug' => $slug,
                       'image' =>  $location,
                   ],

                ));
         }else{
              $Category = Category::create(array_merge(

                   [

                        'name' => $name,
                       'arabic_name' => $arabic_name,
                       'parent_id' => $parent_id,
                       'commision' => $commision,
                       'slug' => $slug
                       
                   ],

                ));
         }



            return response()->json([
                'message' => 'Category successfully Store',
                'Category' => $Category
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
        $data['category'] = Category::find($id);
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
            'parent_id'=>'required',
            'commision'=>'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        
        $name =$request->name;
        $arabic_name = $request->arabic_name;
        $parent_id =$request->parent_id;
        $commision =$request->commision;
       
        if ($request->file('photo')){
            $photoPath =  $request->file('photo')->store('public');
            $photoName = (explode('/', $photoPath))[1];
            $host =$_SERVER['HTTP_HOST'];
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $location = $protocol . $host . "/public/storage/" . $photoName;
             $result= Category::where('id', '=', $id)->update(['name' => $name, 'arabic_name' => $arabic_name, 'parent_id' => $parent_id,'commision' => $commision,'image' => $location]);
        }else{
             $result= Category::where('id', '=', $id)->update(['name' => $name, 'arabic_name' => $arabic_name, 'parent_id' => $parent_id,'commision' => $commision]);
        }
       

        if($result){
            return response()->json([
                'message' => 'Category successfully Update'
               
            ], 201);
        }else{
            return response()->json([
                'message' => 'Category Not successfully Update',
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
        $Category = Category::find($id);

        $result = $Category->delete();

        if($result){
            return response()->json([
                'message' => 'Category successfully Delete',
            ], 201);
        }else{
            return response()->json([
                'message' => 'Category Not successfully Delete',
            ], 400);
        }
    }
}
