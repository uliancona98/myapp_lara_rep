<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogPost extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:191',
            'price' => 'integer|required|min:0|max:10'
        ];
    }


    public function messages()
    {
        $data = '{
            "name": "Aragorn",
            "race": "Human"
        }';
        $marks = array("Peter"=>65, "Harry"=>80, "John"=>78, "Clark"=>90);

        $character = json_encode($marks); 
      return [
        'name.required' => $character,
        'price.required' => $character,
        'price.max' => $character,
    ];
    }

}
