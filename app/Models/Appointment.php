<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'enrolle_id', 'health_care_id', 'title', 'appointment_reason', 'appointment_data',  'status',  'approved_date', 'approval_comment', 'slug'
    ];

    public function enrolle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enrolle::class, 'enrolle_id');
    }

    public function hospital(): \Illuminate\Database\Eloquent\Relations\BelongsTo
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
