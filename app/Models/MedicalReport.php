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

class MedicalReport extends Model implements HasMedia
{
    use Auditable, HasFactory, InteractsWithMedia, SoftDeletes;

    protected $appends = [
        'file',
    ];

    public $table = 'medical_reports';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const REPORT_TYPE_SELECT = [
        'exame de sangue' => 'exame de sangue',
        'ultrassom' => 'ultrassom',
    ];

    protected $fillable = [
        'appointment_id',
        'report_type',
        'observations',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class, 'appointment_id');
    }

    public function getFileAttribute()
    {
        return $this->getMedia('file');
    }
}
