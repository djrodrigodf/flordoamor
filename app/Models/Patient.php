<?php

namespace App\Models;

use App\Traits\Auditable;
use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Patient extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, Auditable, HasFactory;

    public $table = 'patients';

    public static $searchable = [
        'name',
        'email',
        'phone',
        'cpf',
    ];

    protected $dates = [
        'birth_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'birth_date',
        'rg',
        'cpf',
        'address',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'postal_code',
        'observations',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    public function patientDocuments()
    {
        return $this->hasMany(Document::class, 'patient_id', 'id');
    }

    public function patientTreatments()
    {
        return $this->hasMany(Treatment::class, 'patient_id', 'id');
    }

    public function patientInsurances()
    {
        return $this->hasMany(Insurance::class, 'patient_id', 'id');
    }

    public function patientEmergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'patient_id', 'id');
    }

    public function getBirthDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setBirthDateAttribute($value)
    {
        $this->attributes['birth_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }
}
