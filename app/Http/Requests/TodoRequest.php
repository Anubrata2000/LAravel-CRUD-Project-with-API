<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'status'       => 'required|in:Pending,In Progress,Completed',
            'priority'     => 'required|in:Low,Medium,High',
            'due_date'     => 'nullable|date',
            'completed_at' => 'nullable|date',
            'comments'     => 'nullable|string',
        ];
    }
}
