<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use SoftDeletes, Auditable, HasFactory;

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
        return $this->hasMany(Appointment::class, 'doctor_id', 'id');
    }
}
