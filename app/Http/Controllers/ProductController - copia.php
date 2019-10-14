<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json($products,200);
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
     * @param  \Illuminate\Http\Request\ProductCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
		// Create a new product
		$product = Product::create($request->all());
		// Return a response with a product json
		// representation and a 201 status code   
		return response()->json($product,201);
    }

    /**
     * Display the specified resource.
     *
     * @param id    
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product,200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @param id    
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product, $id)
    {
        //First find the product to be updated
        $product = Product::find($id);
        if($product){
            //Then assign all the variables and save the product
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->save();  
            return response()->json(200);
        }
        return response()->json(204);   

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(204);
    }

}
