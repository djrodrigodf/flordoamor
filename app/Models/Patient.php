<?php

namespace App\Models;

use App\Traits\Auditable;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Patient extends Model implements HasMedia
{
    use Auditable, HasFactory, InteractsWithMedia, SoftDeletes;

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

    /**
     * Relacionamento com agendamentos (appointments) do paciente.
     */
    public function patientAppointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id', 'id');
    }

    /**
     * Relacionamento com documentos do paciente.
     */
    public function patientDocuments()
    {
        return $this->hasMany(Document::class, 'patient_id', 'id');
    }

    /**
     * Relacionamento com tratamentos do paciente.
     */
    public function patientTreatments()
    {
        return $this->hasMany(Treatment::class, 'patient_id', 'id');
    }

    /**
     * Relacionamento com seguros do paciente.
     */
    public function patientInsurances()
    {
        return $this->hasMany(Insurance::class, 'patient_id', 'id');
    }

    /**
     * Relacionamento com contatos de emergência do paciente.
     */
    public function patientEmergencyContacts()
    {
        return $this->hasMany(EmergencyContact::class, 'patient_id', 'id');
    }

    /**
     * Registrar conversões de mídia para Spatie Media Library.
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    /**
     * Função para serializar datas corretamente no formato esperado.
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Setter para o campo telefone (removendo caracteres especiais).
     */
    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    /**
     * Getter para o campo telefone (formatando com máscara).
     */
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

    /**
     * Setter para o campo CPF (removendo caracteres especiais).
     */
    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = preg_replace('/\D/', '', $value);
    }

    /**
     * Getter para o campo CPF (formatando com máscara de CPF).
     */
    public function getCpfAttribute($value)
    {
        $value = preg_replace('/\D/', '', $value);
        if (strlen($value) === 11) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", '$1.$2.$3-$4', $value);
        }

        return $value;
    }
}
