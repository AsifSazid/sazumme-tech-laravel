<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HeroAreaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image_id' => 'nullable|exists:images,id',
        ];
    }
}
