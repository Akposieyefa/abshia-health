<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @method create(array $array)
 * @method where(string $string, string $string1, $id)
 * @method latest()
 * @method findOrFail($id)
 */
class Appointment extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'enrolle_id', 'health_care_id', 'title', 'appointment_reason', 'appointment_date',  'status',  'approved_date', 'approval_comment', 'slug'
    ];

    public function enrolle(): BelongsTo
    {
        return $this->belongsTo(Enrolle::class, 'enrolle_id');
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(HealthCare::class, 'health_care_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
