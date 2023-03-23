<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'course_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'tag' => ['nullable', 'string'],
            'cover_url' => ['nullable', 'string'],
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
            'course_program' => ['required', 'array'],
        ];
    }

    public function attributes(): array
    {
        return [
            'course_name' => 'НАЗВАНИЕ КУРСА',
            'description' => 'ОПИСАНИЕ КУРСА',
            'course_program' => 'ПРОГРАММА КУРСА',
        ];
    }

    /**
     * @return string[]
     */
    public function messages (): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
        ];
    }

}
