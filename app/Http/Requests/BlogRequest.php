<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('PUT')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */


    public function createRules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string', 'max:500', 'min:10'],
            'slug' => ['required', 'alpha_dash', 'unique:blogs,slug'],
            'image' => ['sometimes', 'nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string', 'max:500', 'min:10'],
            'slug' => ['required', 'alpha_dash', 'unique:blogs,slug,'.$this->blog->id.',id'],
            'image' => ['sometimes', 'nullable', 'mimes:jpg,png,jpeg', 'max:5120'],
        ];
    }
}
