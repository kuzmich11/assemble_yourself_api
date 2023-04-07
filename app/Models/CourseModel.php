<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/** @OA\Schema(
 *     @OA\Xml(name="Courses"),
 *     @OA\Property(property="id", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="course_name", type="string", readOnly="true", description="Название курса"),
 *     @OA\Property(property="description", type="string", readOnly="true", description="Описание курса"),
 *     @OA\Property(property="tag", type="string", readOnly="true"),
 *     @OA\Property(property="cover_url", type="string", description="URL адрес обложки"),
 *     @OA\Property(property="author", type="integer", readOnly="true", example="1"),
 *     @OA\Property(property="start_date", type="string", format="date-time", description="Дата начала курса", readOnly="true"),
 *     @OA\Property(property="end_date", type="string", format="date-time", description="Дата окончания курса", readOnly="true"),
 *     @OA\Property(
 *     property="course_program",
 *     type="array",
 *     description="Содержание программы курса",
 *          @OA\Items (
 *          type="object"
 *          )
 *     ),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Initial creation timestamp", readOnly="true"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Last update timestamp", readOnly="true"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", description="Soft delete timestamp", readOnly="true")
 * )
 *
 * Class CourseModel
 */
class CourseModel extends Model
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

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
        'course_program' => 'array',
    ];

    protected function tag(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class, 'author');
    }

    public function contentModel (): HasOne
    {
        return $this->hasOne(ContentModel::class, 'course_id');
    }

}
