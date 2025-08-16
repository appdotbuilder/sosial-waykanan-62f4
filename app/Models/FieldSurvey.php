<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FieldSurvey
 *
 * @property int $id
 * @property int $application_id
 * @property int $surveyor_id
 * @property \Illuminate\Support\Carbon $survey_date
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string $findings
 * @property string $recommendations
 * @property string $recommendation_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FieldSurveyPhoto> $photos
 * @property-read int|null $photos_count
 * @property-read \App\Models\User $surveyor
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey query()
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereFindings($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereRecommendationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereSurveyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereSurveyorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FieldSurvey whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class FieldSurvey extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'application_id',
        'surveyor_id',
        'survey_date',
        'latitude',
        'longitude',
        'findings',
        'recommendations',
        'recommendation_status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'survey_date' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the application that owns this field survey.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    /**
     * Get the surveyor who conducted this survey.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function surveyor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'surveyor_id');
    }

    /**
     * Get the photos for this field survey.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(FieldSurveyPhoto::class);
    }
}