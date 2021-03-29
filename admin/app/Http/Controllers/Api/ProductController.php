<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Validator;
use DB;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use App\Models\Attribute;
use App\Models\AttributeValue;

class ProductController extends Controller
{

    
    public function index()
    {
        //
    }

    
    public function create()
    {
        //
    }

    public function variations(){
        
        $attributes = Attribute::all();
        foreach ($attributes as $attribute) {
            $attribute->values;
        }
 
        return response()->json($attributes, 200);
    }

    public function deleteAttribute($id){

        $attr = Attribute::find($id);
        
        // It Should be Cascade from database
        AttributeValue::where('attribute_id', $id)->delete();

        if($attr->delete()){
            return response()->json([
                'message' => 'Attribute Deleted Successfully.',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Failed to Delete Attribute.',
            ], 400);
        }

    }

    public function createAttribute(Request $request){
        
        $validator = Validator::make($request->all(), [
            'attribute'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $prodattr = new Attribute();
        $prodattr->name = $request->attribute;
         
        if($prodattr->save()){
            return response()->json([
                'message' => 'Product Created Successfully',
                'attribute' => $prodattr
            ], 200);
        }else{
            return response()->json([
                'message' => 'Failed to Create Product.'
            ], 400);
        }

    }

    public function updateAttribute(Request $request){
        
        $validator = Validator::make($request->all(), [
            "id" => "required",
            'attribute'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $prodattr = Attribute::find($request->id);
        $prodattr->name = $request->attribute;
         
        if($prodattr->update()){
            return response()->json([
                'message' => 'Product Updated Successfully',
                'attribute' => $prodattr
            ], 200);
        }else{
            return response()->json([
                'message' => 'Failed to Create Product.'
            ], 400);
        }

    }

    public function createAttributeValue(Request $request){
        
        $validator = Validator::make($request->all(), [
            'attribute_value'=>'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $attrvalue = new AttributeValue();
        $attrvalue->attribute_id = $request->attribute_id;
        $attrvalue->value = $request->attribute_value;
         
        if($attrvalue->save()){
            
            return response()->json([
                'message' => 'Attribute Value Added Successfully',
                'attribute_value' => $attrvalue
            ], 200);

        }else{
            
            return response()->json([
                'message' => 'Failed to Create Attribute Value.'
            ], 400);
        }

    }

    
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'product_name'=>'required',
            'category' => 'required',
            'unit' => 'required',
            'currency' => 'required',
            'brand' => 'required',
            'stock' => 'required',
            // 'default_image' => 'required',
            // 'meta_keywords' => 'required',
            // 'meta_description' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }


        DB::beginTransaction();
        try{

            $product = new Product();

            $product->name = $request->product_name;
            $product->category_id = $request->category;
            $product->user_id = $request->user()->id;
            $product->unit_id = $request->unit;
            $product->currency_id = $request->currency;
            $product->brand_id = $request->brand;
            $product->stock = $request->stock;
            $product->default_image = "image.png";
            $product->meta_keywords = "meta keywords";
            $product->meta_description = "meta description";
            $product->short_description = $request->short_description;
            $product->long_description = $request->long_description;
            $product->slug = Str::slug($request->name, '-');
            $product->save();


            DB::commit();

            return response()->json([
                'message' => 'Product Created Successfully'
            ], 200);

        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }

    }

    public function uploadProductImages(Request $request){

        DB::beginTransaction();
        try{

            $product = Product::where('slug', $request->slug)->first();

            if($files = $request->file('images')){

                $validator = Validator::make($request->all(), [
                    'images' => 'required',
                    'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:1024',
                ]);

                if($validator->fails()){
                    return response()->json(['error' => $validator->errors()->first()], 200);
                }
                
                foreach($files as $file){
                  

                    $uniqname = uniqid();
                    $name = $uniqname.'.'.$file->getClientOriginalExtension();
                    $file->move(public_path().'/img/products/', $name);  
                    
                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = $name;
                    $productImage->save();

                }

            }

            DB::commit();
            return response()->json(['success' => "Image Uploaded Successfully"], 200);
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
