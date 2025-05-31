<?php

namespace App\Http\Requests\Api;

use App\EnumsTasksStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string','min:3' ,'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::enum(EnumsTasksStatus::class)],
            'completionDate' => ['nullable', 'string']
            ];
    }
}
