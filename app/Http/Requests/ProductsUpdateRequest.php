<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Validation\Factory as ValidationFactory;


class ProductsUpdateRequest extends FormRequest
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
            'price' => 'required|numeric|not_in:0|min:0'
        ];
    }
    public function messages()
    {
        return [
            'price.numeric' =>
                [
                    'id'=> 'UPDATE-2',
                    'titulo'=> 'Unprocessable Entity',
                    'descripcion'=>  'El atributo price no es un número',
                    'codigo de error'=> 'ERROR-1',
                    'respuesta HTTP'=> '422'
                ],
            'price.gt' =>             
                [
                    'id'=> 'UPDATE-3',
                    'titulo'=> 'Unprocessable Entity',
                    'descripcion'=>  'El cliente envía la representación de un producto donde el atributo price tiene un valor de -20',
                    'codigo de error'=> 'ERROR-1',
                    'respuesta HTTP'=> '422'
                ]
        ];
    }
}
