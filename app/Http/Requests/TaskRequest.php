<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\EnumsTasksStatus;
use Illuminate\Validation\Rule;

class TaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'status'=> ['required', Rule::enum(EnumsTasksStatus::class)],
            'completionDate'=> 'nullable|date',
        ];
    }
}
