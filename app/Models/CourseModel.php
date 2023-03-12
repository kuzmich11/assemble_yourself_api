<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CourseModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'courses';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_name',
        'description',
        'tag',
        'cover_url',
        'author',
        'start_date',
        'end_date',
        'course_program',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function content (): HasOne
    {
        return $this->hasOne(ContentModel::class);
    }

//    public function getJWTIdentifier()
//    {
//        return $this->getKey();
//    }
//
//    public function getJWTCustomClaims(): array
//    {
//        return [];
//    }
}
