<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\RequestBody(
 *     request="UserArray",
 *     description="Перечень свойств пользователя",
 *     required=true,
 *     @OA\JsonContent(
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="name", type="string", description="Имя пользователя"),
 *     @OA\Property(property="email", type="string", format="email", example="user1@mail.com"),
 *     @OA\Property(property="password", type="string", format="password", minLength=8, example="PassWord12345"),
 *     @OA\Property(property="about", type="string", example="Обо мне"),
 *     )
 * )
 */
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
            'id' => ['required', 'integer'],
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
