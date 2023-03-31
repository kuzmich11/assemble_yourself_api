<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', Rule::unique('users')->ignore($this->id)],
            'password' => ['required', 'string', 'min:8'],
            'about' => ['nullable'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'ИМЯ',
            'email' => 'EMAIL',
            'password' => 'ПАРОЛЬ',
        ];
    }

    /**
     * @return string[]
     */
    public function messages (): array
    {
        return [
            'required' => 'Поле :attribute обязательно для заполнения',
            'unique' => 'Пользователь с таким email уже зарегистрирован',
            'email' => 'Поле :attribute должно быть действующим email-адресом',
            'min' => 'Поле :attribute должно содержать минимум :min символов',
        ];
    }
}
