<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method create(array $array)
 */
class Enrolle extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'user_id', 'agent_id', 'title', 'surname', 'first_name', 'middle_name', 'gender', 'phone_number',  'dob',  'address',
        'blood_group', 'state_id', 'lga_id',  'town', 'nok_name', 'nok_address', 'nok_phone', 'nok_relationship',
        'category_id', 'genotype', 'marital_status', 'no_of_dependants',  'health_care_id',
        'existing_medical_condition',  'hypertension', 'sickle_cell', 'cancer',  'kidney_issue',  'slug', 'emp_id'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lga(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Lga::class, 'lga_id');
    }

    public function state(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function primaryHealthCare(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(HealthCare::class, 'health_care_id');
    }

    public function agent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'surname'
            ]
        ];
    }

}
