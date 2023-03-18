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
    public function rules($user_id): array
    {
        return [
            'course_name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'tag' => ['nullable', 'string'],
            'cover_url' => ['required', 'string'],
            'author' => $user_id,
            'start_date' => ['nullable'],
            'end_date' => ['nullable'],
            'course_program' => ['required, array'],
        ];
    }
}
