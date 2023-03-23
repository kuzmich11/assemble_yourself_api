<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class Course extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'author_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'price',
        'metadata',
    ];

    protected $casts = [
        'users_ids' => 'array',
    ];

    protected $dates = [
        'start_date',
        'end_date',
    ];

    // найти учеников на курсе
    public function studies(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'courses_has_users');
    }

    // найти автора курса
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
