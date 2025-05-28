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
            'title' => ['required', 'string','min:3' ,'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::enum(EnumsTasksStatus::class)],
            'completionDate' => ['nullable', 'string'],
        ];
    }
    public function messages(): array

    {
        return [
            'title.min' => 'A title is required more than 3 characters by Sara',
//            'status'=>[
//                'required'=>'The task status is required.',
//                'enum' => 'Valid values are `toDo` and `inProgress` and `completed`.',
//            ],
           // 'status.enum' => 'The selected :attribute is invalid by sara',
            'status' => [
                EnumsTasksStatus::class => 'The setting :input is invalid By sara',
            ],

        ];
    }
}
