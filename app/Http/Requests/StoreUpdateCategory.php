<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateCategory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // $url = $this->url;
        $url = $this->segment(2);

        return [
            'title' => "required|min:3|max:150|unique:categories,title,{$url},url",
            'description' => 'required|min:3|max:150'
        ];
    }
}
