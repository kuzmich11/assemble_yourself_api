<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

/** @OA\Schema(
 *     @OA\Xml(name="Courses"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="name", type="string", readOnly="true", description="Имя пользователя"),
 *     @OA\Property(property="email", type="string", readOnly="true", format="email", example="user1@mail.com"),
 *     @OA\Property(property="password", type="string", readOnly="true", format="password", minLength=8, example="PassWord12345"),
 *     @OA\Property(property="about", type="string", readOnly="true", example="Обо мне"),
 * )
 *
 * Class User
 */
class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    public function courseModel ():HasMany
    {
        return $this->hasMany(CourseModel::class, 'author');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }
}
