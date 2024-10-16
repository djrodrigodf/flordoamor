<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model' => '\App\Models\Appointment',
            'date_field' => 'appointment_date',
            'field' => 'appointment_date',
            'prefix' => 'appointment',
            'suffix' => 'patiente',
            'route' => 'admin.appointments.edit',
        ],
    ];

    public function index()
    {
        $events = [];
        foreach ($this->sources as $source) {
            foreach ($source['model']::all() as $model) {
                $crudFieldValue = $model->getAttributes()[$source['date_field']];

                if (! $crudFieldValue) {
                    continue;
                }

                $events[] = [
                    'title' => trim($source['prefix'].' '.$model->{$source['field']}.' '.$source['suffix']),
                    'start' => $crudFieldValue,
                    'url' => route($source['route'], $model->id),
                ];
            }
        }

        return view('admin.calendar.calendar', compact('events'));
    }
}
