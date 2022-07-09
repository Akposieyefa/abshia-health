<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Claim extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'health_care_id', 'enrolle_id', 'date_of_admission', 'date_of_discharge',
        'treatment_details', 'diagnosis', 'investigations', 'cost', 'payment_status'
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
