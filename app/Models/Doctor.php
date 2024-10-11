<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use Auditable, HasFactory, SoftDeletes;

    public $table = 'doctors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public static $searchable = [
        'name',
        'crm',
        'phone',
        'email',
    ];

    protected $fillable = [
        'name',
        'specialty',
        'crm',
        'phone',
        'email',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id', 'id')->whereNull('deleted_at');
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function getPhoneAttribute($value)
    {
        $value = preg_replace('/\D/', '', $value);
        $length = strlen($value);
        if ($length === 11) {
            return preg_replace("/(\d{2})(\d{5})(\d{4})/", '($1) $2-$3', $value);
        } elseif ($length === 10) {
            return preg_replace("/(\d{2})(\d{4})(\d{4})/", '($1) $2-$3', $value);
        } else {
            return $value;
        }
    }
}
