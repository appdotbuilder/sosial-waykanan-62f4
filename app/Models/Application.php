<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * App\Models\Application
 *
 * @property int $id
 * @property string $application_number
 * @property int $user_id
 * @property int $assistance_type_id
 * @property string $applicant_name
 * @property string $nik
 * @property string $phone
 * @property string $address
 * @property string $village
 * @property string $district
 * @property float|null $requested_amount
 * @property string $reason
 * @property string $status
 * @property string|null $notes
 * @property string|null $rejection_reason
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property int|null $reviewed_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AssistanceType $assistanceType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ApplicationDocument> $documents
 * @property-read int|null $documents_count
 * @property-read \App\Models\FieldSurvey|null $fieldSurvey
 * @property-read \App\Models\User|null $reviewer
 * @property-read \App\Models\User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Application newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Application query()
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicantName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApplicationNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereAssistanceTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereDistrict($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRejectionReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereRequestedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereReviewedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereSubmittedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Application whereVillage($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class Application extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'application_number',
        'user_id',
        'assistance_type_id',
        'applicant_name',
        'nik',
        'phone',
        'address',
        'village',
        'district',
        'requested_amount',
        'reason',
        'status',
        'notes',
        'rejection_reason',
        'submitted_at',
        'approved_at',
        'completed_at',
        'reviewed_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'requested_amount' => 'decimal:2',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            if (empty($application->application_number)) {
                $application->application_number = 'BST-' . date('Y') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /**
     * Get the user who submitted this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the assistance type for this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assistanceType(): BelongsTo
    {
        return $this->belongsTo(AssistanceType::class);
    }

    /**
     * Get the user who reviewed this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the documents for this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(ApplicationDocument::class);
    }

    /**
     * Get the field survey for this application.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function fieldSurvey(): HasOne
    {
        return $this->hasOne(FieldSurvey::class);
    }

    /**
     * Get the status label.
     *
     * @return string
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft' => 'Draft',
            'submitted' => 'Diajukan',
            'under_review' => 'Sedang Ditinjau',
            'field_survey' => 'Survey Lapangan',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }
}