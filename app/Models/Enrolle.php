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
 */
class Enrolle extends Model
{
    use HasFactory, Sluggable, SoftDeletes;

    protected $fillable = [
        'user_id', 'agent_id', 'title', 'surname', 'first_name', 'middle_name', 'gender', 'phone_number',  'dob',  'address',
        'blood_group', 'state_id', 'lga_id',  'town', 'nok_name', 'nok_address', 'nok_phone', 'nok_relationship',
        'category_id', 'genotype', 'marital_status', 'no_of_dependants',  'health_care_id', 'is_subscribed',
        'existing_medical_condition',  'hypertension', 'plan_id', 'sickle_cell', 'cancer',  'kidney_issue',  'slug', 'emp_id', 'from_date', 'to_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class, 'lga_id');
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class, 'state_id');
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }

    public function primaryHealthCare(): BelongsTo
    {
        return $this->belongsTo(HealthCare::class, 'health_care_id');
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
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
