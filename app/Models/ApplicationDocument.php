<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ApplicationDocument
 *
 * @property int $id
 * @property int $application_id
 * @property string $document_type
 * @property string $original_name
 * @property string $file_path
 * @property string $mime_type
 * @property int $file_size
 * @property bool $is_verified
 * @property string|null $verification_notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Application $application
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereApplicationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereIsVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereOriginalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ApplicationDocument whereVerificationNotes($value)
 * @method static \Illuminate\Database\Eloquent\Factories\Factory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class ApplicationDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'application_id',
        'document_type',
        'original_name',
        'file_path',
        'mime_type',
        'file_size',
        'is_verified',
        'verification_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'file_size' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the application that owns this document.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }
}