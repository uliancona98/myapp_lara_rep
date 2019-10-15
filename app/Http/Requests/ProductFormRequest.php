<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Hashing\Hasher;
class ProductFormRequest extends FormRequest
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

    protected function failedValidation(Validator $validator){
        $response = ['errors' => []];
        $arrayTemp = [];
        foreach($validator->errors()->toArray() as $key => $value){
            //Form the array with a specify representation
            $arrayTemp = [
                'code' => 'ERROR-1',
                'source' => $key,
                'title' => 'Unprocessable Entity',
                'detail' => $value[0], //this will only show an error for an attribute, to show all the errors
                //that generated an attribute, it's necessary to do another foreach loop for the array ($item)
            ];
            array_push($response['errors'], $arrayTemp);
        }
        throw new HttpResponseException(response()->json($response,422));
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
            'price' => 'bail|required|numeric|gt:0'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The product :attribute is neccesary',
            'price.required' => 'The product :attribute is neccesary',
            'price.numeric' => 'The :attribute should be numeric',
            'price.gt' => 'The :attribute must be greater than zero'
        ];
    }
}
