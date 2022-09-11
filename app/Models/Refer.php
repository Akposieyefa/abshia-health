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
 * @method findOrFail($id)
 */
class Refer extends Model
{
    use HasFactory, SoftDeletes, Sluggable;

    protected $fillable = [
        'enrolle_id', 'health_care_id', 'case', 'hospital_name',  'remark',  'slug'
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
                'source' => 'case'
            ]
        ];
    }
}
