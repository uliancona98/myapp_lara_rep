<?php
namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductFormRequest;
 /**
 * @author Ulises Ancona>
 */
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rows = Product::count();
        if($rows>0){

            $products = Product::all();
            return response()->json($products,200);
        }
        return response()->json([],200);
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
     * @param  \Http\Request\ProductFormRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductFormRequest $request)
    {
        $validated = $request->validated();
        $product = Product::create($request->all());
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
        if($product){
            return response()->json($product,200);
        }
        $response = [
            'errors' => [
                [
                    'code' => 'ERROR-2',
                    'title' => 'Not Found',
                    'detail' => 'There is not a product with the id: '.$id
                ]
            ]  
        ];      
        return response()->json($response, 404);
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
     * @param  \Illuminate\Http\ProductFormRequest  $request
     * @param  \App\Product  $product
     * @param id    
     * @return \Illuminate\Http\Response
     */
    public function update(ProductFormRequest $request, $id)
    {
        //First find the product to be updated
        $product = Product::find($id);
        if($product){
            //Then assign all the variables and save the product
            $product->name = $request->input('name');
            $product->price = $request->input('price');
            $product->save();
            return response()->json($product,200);
        }
         //else send a response with a 404 status
        $response = [
            'errors' => [
                [
                    'code' => 'ERROR-2',
                    'title' => 'Not Found',
                    'detail' => 'There is not a product with the id: '.$id
                ]
            ]
        ];
        return response()->json($response,404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json('',204);
        }
        $response = [
            'errors' => [
                [
                    'code' => 'ERROR-2',
                    'title' => 'Not Found',
                    'detail' => 'There is not a product with the id: '.$id
                ]
            ]
        ];
        return response()->json($response,404);
    }

}
