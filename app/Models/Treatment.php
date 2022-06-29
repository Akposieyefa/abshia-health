<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method findOrFail($id)
 * @method where(string $string, string $string1, $id)
 * @method create(array $array)
 */
class Treatment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'enrolle_id', 'health_care_id', 'verified_by', 'date_and_time', 'is_capitated', 'is_ffs', 'drugs', 'cost_of_treatment',
        'height', 'weight', 'blood_pressure', 'pulse', 'respiration', 'temperature', 'treatment_give', 'is_referred',  'summary'
    ];

    public function enrolle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Enrolle::class, 'enrolle_id');
    }

    public function hospital(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HealthCare::class, 'health_care_id');
    }

}
