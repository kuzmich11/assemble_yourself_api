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
 *     @OA\Property(property="course_id", type="integer", readOnly="true", description="ID курса", example="1"),
 *     @OA\Property(property="page", type="integer", readOnly="true", description="Номер страницы курса", example="1"),
 *     @OA\Property(property="page_title", type="string", readOnly="true", description="Заголовок страницы"),
 *     @OA\Property(property="content", type="string", readOnly="true", description="Содержание курса"),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", description="Soft delete timestamp", readOnly="true"),
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
        'page',
        'page_title',
        'content',
    ];

    public function courseModel (): HasOne
    {
        return $this->hasOne(CourseModel::class);
    }
}
