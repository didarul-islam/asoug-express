<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;



use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BrandController;

use App\Http\Controllers\Api\ProductController;

use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\CurrencyController;



/**
 * 
 * User Route
 */

 Route::get("/", function(){
     echo "HELLO";
 });


Route::group([
    
    'prefix' => 'auth'
], function ($router) {

    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']); 

});



Route::group(['prefix' => '/v1','middleware' => ['assign.guard:users','jwt.auth']],function ()
{
	


});










/**
 * 
 * Vendor Route
 */
Route::group([
    'prefix' => 'vendor',
    'middleware' => 'auth'
], function () {
    Route::post('/create-product', [ProductController::class, 'store']);
    Route::post('/create-variation', [ProductController::class, 'createVariation']);
});


Route::group(['prefix' => '/vendor/v1','middleware' => ['assign.guard:vendors','jwt.auth']],function ()
{
	Route::get('/demo', function(){
        return "Hello From Vendor";
    });	
});








/**
 * 
 * Admin Route
 */



Route::group([
    'prefix' => 'admin'
], function () {

    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/logout', [AdminController::class, 'logout']);
    Route::post('/refresh', [AdminController::class, 'refresh']);
    Route::get('/admin-profile', [AdminController::class, 'adminProfile']); 

});





Route::group(['prefix' => '/admin/v1','middleware' => ['assign.guard:admins','jwt.auth']],function ()
{
	Route::apiResource('category', CategoryController::class);
    // JS file upload is not possible throug put method thats why used post method
    Route::post('update-category/{id}', [CategoryController::class, 'update']);


    // Product Routes
    Route::apiResource('product', ProductController::class);
    Route::post('product/upload-images', [ProductController::class, 'uploadProductImages']);

    // Product Variations Routes
    Route::get('variations', [ProductController::class, 'variations']);
    Route::post('create-attribute', [ProductController::class, 'createAttribute']);
    Route::post('update-attribute', [ProductController::class, 'updateAttribute']);
    Route::delete('delete-attribute/{id}', [ProductController::class, 'deleteAttribute']);

    Route::post('create-attribute-value', [ProductController::class, 'createAttributeValue']);
    Route::post('product/create-variation', [ProductController::class, 'createVariation']);


    // Category
    Route::apiResource('category', CategoryController::class);
    Route::post('update-category/{id}', [CategoryController::class,'update']);

    // Brand
    Route::apiResource('brand', BrandController::class);
    Route::post('update-brand/{id}', [BrandController::class, 'update']);


    // Country
    Route::apiResource('country', CountryController::class);
    Route::post('update-country/{id}', [CountryController::class, 'update']);

    // Unit
    Route::apiResource('unit', UnitController::class);
    Route::post('update-unit/{id}', [UnitController::class, 'update']);

    // Unit
    Route::apiResource('currency', CurrencyController::class);
    Route::post('update-currency/{id}', [CurrencyController::class, 'update']);	
});
