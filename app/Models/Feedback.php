<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method create(array $array)
 * @method findOrFail($id)
 * @method latest()
 */
class Feedback extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'market_reality', 'importance', 'solution_platform', 'key_things', 'ideal_relationship', 'facility_band',
        'patient_percentage', 'second_third_investigation', 'perceive_hmo', 'name'
    ];

}
