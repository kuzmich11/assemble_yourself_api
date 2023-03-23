<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class ContentModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'contents';

    protected $fillable = [
        'course_id',
        'content',
    ];

    public function courseModel (): HasOne
    {
        return $this->hasOne(CourseModel::class);
    }
}
