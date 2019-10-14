<?php
namespace App\Http\Controllers;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
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
        $products = Product::all();
        if($rows>0){
            $json = [
                'success' =>[
                    'id'=> 'LIST-1',
                    'descripcion'=>  'La lista de productos se muestra correctamente',
                    'respuesta HTTP'=> '200'
                ],
                'products'=>[
                $products]
            ];
            return response()->json($json);
        }
        $json = [
            'success' =>[
                'id'=> 'LIST-2',
                'descripcion'=>  'No hay ningún producto en la aplicación',
                'respuesta HTTP'=> '200'
            ],
            'products'=>[]
        ];
        return response()->json($json);
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
     * @param  \Http\Request\ProductCreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCreateRequest $request)
    {
		// Create a new product
		$product = Product::create($request->all());
		// Return a response with a product json
        // representation and a 201 status code
        $json = [
            'success' => [
                'id'=> 'CREATE-1',
                'descripcion'=>  'Producto guardado con éxito',
                'respuesta HTTP'=> '201'
            ],
            'product' => [
                $product
            ]
        ];
		return response()->json($json);
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
            $json = [
                'success' => [
                    'id'=> 'SHOW-1',
                    'descripcion'=>  'Producto editado con éxito',
                    'respuesta HTTP'=> '200'
                ],
                'product' => [
                    $product
                ]
            ];
            return response()->json($product,200);
        }
        $error = [
            'errors' =>[
                'id'=> 'SHOW-2',
                'titulo'=> 'Not found',
                'descripcion'=>  'No hay un producto con ese ID',
                'codigo de error'=> 'ERROR-2',
                'respuesta HTTP'=> '404'
            ]
        ];                
        return response()->json($error);
        //return response()->json(204);   

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
            $json = [
                'success' => [
                    'id'=> 'UPDATE-1',
                    'descripcion'=>  'El Producto se muestra correctamente',
                    'respuesta HTTP'=> '200'
                ],
                'product' => [
                    $product
                ]
            ];
            return response()->json($json);
        }
        $error = [
            'errors' =>[
                'id'=> 'UPDATE-4',
                'titulo'=> 'Not found',
                'descripcion'=>  'El cliente manda una solicitud solicitando editar un producto con un ID que no existe',
                'codigo de error'=> 'ERROR-2',
                'respuesta HTTP'=> '404'
            ]
        ];       
        return response()->json($error);
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
            $product = Product::findOrFail($id);
            $product->delete();
            $json = [
                'success' => [
                    'id'=> 'DELETE-1',
                    'descripcion'=>  'Producto eliminado correctamente',
                    'respuesta HTTP'=> '204'
                ]
            ];
            return response()->json($json);
        }
        $error = [
            'errors' =>[
                'id'=> 'DELETE-2',
                'titulo'=> 'Not found',
                'descripcion'=>  'No hay un producto con ese ID',
                'codigo de error'=> 'ERROR-2',
                'respuesta HTTP'=> '404'
            ]

        ];                
        return response()->json($error);
    }

}
