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

    protected $casts = [
        'start_date' => 'datetime:d-m-Y', // Свой формат
        'end_date' => 'datetime:d-m-Y',
    ];

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function contentModel (): HasOne
    {
        return $this->hasOne(ContentModel::class, 'course_id');
    }

}
