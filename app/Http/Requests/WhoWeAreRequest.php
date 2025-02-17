<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WhoWeAreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }
}

