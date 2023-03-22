<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditUserRequest extends FormRequest
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
            'is_admin' => ['required', 'boolean'],
            'is_author' => ['required', 'boolean'],
            'username' => ['nullable', 'string', 'min:2', 'max:20'],
            'first_name' => ['required', 'string', 'min:2', 'max:20'],
            'last_name' => ['required', 'string', 'min:2', 'max:20'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:5', 'max:10'],
        ];
    }

    public function attributes(): array
    {
        return [
            'is_admin' => 'Тип пользователя (права)',
            'is_author' => 'Тип пользователя (авторство)',
            'username' => 'Никнейм',
            'first_name' => 'Имя',
            'name' => 'Имя',
            'last_name' => 'Фамилия',
            'email' => 'Почта',
            'password' => 'Пароль',
        ];
    }
}
