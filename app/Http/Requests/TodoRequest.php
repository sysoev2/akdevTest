<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|max:255',
            'description' => 'nullable|string',
            'complete' => 'boolean',
            'todo_list_id' => 'required|exists:todo_lists,id'
        ];

        if($this->method() === "PUT" || $this->method() === 'PATCH') {
            $rules['todo_list_id'] = 'exists:todo_lists,id';
        }
        return $rules;
    }
}
