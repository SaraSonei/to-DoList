<?php

namespace App\Http\Requests;

use App\EnumsTasksStatus;
Use App\EnumPerPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskFilterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['nullable','string','max:255'],
            'status' => ['nullable',Rule::enum(EnumsTasksStatus::class)],
            'dateFrom' => ['nullable','date'],
            'dateTo' => ['nullable','date','after_or_equal:dateFrom'],
            'perPage' => ['nullable','integer ',Rule::enum(EnumPerPage::class)],
        ];
    }
}
