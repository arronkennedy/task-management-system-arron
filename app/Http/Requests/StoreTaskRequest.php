<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status'      => ['required', 'in:pending,in_progress,completed,cancelled'],
            'priority'    => ['required', 'in:low,medium,high,critical'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'due_date'    => ['nullable', 'date', 'after_or_equal:today'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'      => 'Task title is required.',
            'title.min'           => 'Task title must be at least 3 characters.',
            'due_date.after_or_equal' => 'Due date must be today or in the future.',
        ];
    }
}