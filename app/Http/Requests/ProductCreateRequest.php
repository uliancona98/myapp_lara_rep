<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Validation\Factory as ValidationFactory;
 /**
 * @author Ulises Ancona>
 */
class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    protected function failedValidation(Validator $validator) { 
        throw new HttpResponseException(
            
            response()->json([
            'status' => false,
            'errors' => $validator->errors()->messages()
          ], 200)
        ); 
      }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|gt:0'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 
                [
                    'id' => 'CREATE-2',
                    'titulo' => 'Unprocessable Entity',
                    'descripcion' =>  'El atributo name no es enviado en la solicitud',
                    'codigo de error' => 'ERROR-1',
                    'respuesta HTTP' => '422',
                ],
            'price.required' => 
                [
                    'id' => 'CREATE-3',
                    'titulo' => 'Unprocessable Entity',
                    'descripcion' => 'El atributo price no es enviado en la solicitud',
                    'codigo de error'=> 'ERROR-1',  
                    'respuesta HTTP'=> '422',  
                ],
            'price.numeric' =>
                [
                    'id'=> 'CREATE-4',
                    'titulo'=> 'Unprocessable Entity',
                    'descripcion'=>  'El atributo price no es un número',
                    'codigo de error'=> 'ERROR-1',
                    'respuesta HTTP'=> '422',
                ],
            'price.gt' =>   //"El atributo price es menor o igual a 0"              
                [
                    'id'=> 'UPDATE-3',
                    'titulo'=> 'Unprocessable Entity',
                    'descripcion'=>  'El cliente envía la representación de un producto donde el atributo price tiene un valor de -20',
                    'codigo de error'=> 'ERROR-1',
                    /*'precondiciones'=>  'El Cliente tiene tiene una representación de un producto que quiere agregar a la aplicación',*/
                    'respuesta HTTP'=> '422'
                ]
        ];
    }
}
