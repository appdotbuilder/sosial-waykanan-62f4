<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\FieldSurveyPhoto
 *
 * @property int $id
 * @property int $field_survey_id
 * @property string $photo_path
 * @property string|null $description
 * @property string|null $photo_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FieldSurvey $fieldSurvey
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto whereFieldSurveyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto wherePhotoType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurveyPhoto whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FieldSurveyPhoto extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'field_survey_id',
        'photo_path',
        'description',
        'photo_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the field survey that owns this photo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fieldSurvey(): BelongsTo
    {
        return $this->belongsTo(FieldSurvey::class);
    }
}