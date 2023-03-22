<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Courses;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
//        return false;
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'author_id' => ['required', 'string'],
            'title' => ['required', 'string', 'min:2', 'max:50'],
            'description' => ['required', 'string', 'min:2', 'max:200'],
            'start_date' => ['required', 'string'],
            'end_date' => ['required', 'string'],
            'price' => ['required', 'string', 'min:4' , 'max:8']
        ];
    }

    public function attributes(): array
    {
        return [
            'author_id' => 'Автор',
            'title' => 'Название курса',
            'description' => 'Описание курса',
            'start_date' => 'Старт курса',
            'end_date' => 'Окончание курса',
            'price' => 'Цена',
        ];
    }
}
