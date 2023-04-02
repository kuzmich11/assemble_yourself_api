<?php

namespace App\Http\Requests\Courses;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\RequestBody(
 *     request="CourseArray",
 *     description="Перечень свойств курса",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="course_name", type="string", description="Название курса"),
 *     @OA\Property(property="description", type="string", description="Описание курса"),
 *     @OA\Property(property="tag", type="string"),
 *     @OA\Property(property="cover_url", type="string", description="URL адрес обложки"),
 *     @OA\Property(property="start_date", type="string", format="date-time", description="Дата начала курса"),
 *     @OA\Property(property="end_at", type="string", format="date-time", description="Дата окончания курса"),
 *     @OA\Property(
 *     property="course_program",
 *     type="array",
 *     description="Содержание программы курса",
 *          @OA\Items (
 *          type="object"
 *          )
 *     ),
 *     )
 * )
 */
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
    public function messages(): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
        ];
    }

}
