<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class TaskRequest extends FormRequest
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
        $unless = "change_status";
        return [
            'title' => 'required_unless:action,'.$unless.'|max:250',  
            'description' => 'required_unless:action,'.$unless.'|max:250',
            'due_date' => 'required_unless:action,'.$unless.'|date_format:Y-m-d H:i:s|after:now',
        ];
    }
}
