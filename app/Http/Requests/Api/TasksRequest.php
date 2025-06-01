<?php

namespace App\Http\Requests\Api;

use App\EnumPerPage;
use App\EnumsTasksStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TasksRequest extends FormRequest
{
    /*
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable','string','max:255'],
            'status' => ['nullable',Rule::enum(EnumsTasksStatus::class)],
            'dateFrom' => ['nullable','string'],
            'dateTo' => ['nullable','string'],
            'perPage' => ['nullable','integer ',Rule::enum(EnumPerPage::class)],
        ];
    }
}
