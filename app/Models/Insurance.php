<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Insurance extends Model
{
    use SoftDeletes, Auditable, HasFactory;

    public $table = 'insurances';

    protected $dates = [
        'valid_until',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'patient_id',
        'insurance_name',
        'policy_number',
        'valid_until',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function getValidUntilAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setValidUntilAttribute($value)
    {
        $this->attributes['valid_until'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
