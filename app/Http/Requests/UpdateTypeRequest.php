<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTypeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            
            'label' => ['required', 'string', 'max:20', 'unique:types,label,' . $this->type->id],
            'color' => ['required', 'regex:/^#([a-f0-9]{6}|[a-f0-9]{3})$/']
        ];
    }

    public function messages()
    {
        return [
            'label.required' => 'the label is mandatory',
            'label.string' => 'the label must be a text',
            'label.max' => 'the label must be a maximum of 20 characters',
            'label.unique' => 'the label already exists',

            'color.required' => 'color is necessary',
            'color.regex' => 'the color must be in hexadecimal'
        ];
    }
}