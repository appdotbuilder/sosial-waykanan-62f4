<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\AssistanceType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $requirements
 * @property float|null $max_amount
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Application> $applications
 * @property-read int|null $applications_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType query()
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AssistanceType active()
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class AssistanceType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'requirements',
        'max_amount',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'max_amount' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the applications for this assistance type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    /**
     * Scope a query to only include active assistance types.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}