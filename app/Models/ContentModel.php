<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/** @OA\Schema(
 *     @OA\Xml(name="Content"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="course_id", type="integer", readOnly="true", description="ID курса"),
 *     @OA\Property(property="content", type="string", readOnly="true", description="Содержание курса"),
 *  )
 *
 * Class ContentModel
 */
class ContentModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
