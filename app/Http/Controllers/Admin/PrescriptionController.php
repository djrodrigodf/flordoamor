<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyPrescriptionRequest;
use App\Http\Requests\StorePrescriptionRequest;
use App\Http\Requests\UpdatePrescriptionRequest;
use App\Models\Appointment;
use App\Models\Prescription;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class PrescriptionController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('prescription_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Prescription::with(['appointment'])->select(sprintf('%s.*', (new Prescription)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'prescription_show';
                $editGate      = 'prescription_edit';
                $deleteGate    = 'prescription_delete';
                $crudRoutePart = 'prescriptions';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('appointment_appointment_date', function ($row) {
                return $row->appointment ? $row->appointment->appointment_date : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'appointment']);

            return $table->make(true);
        }

        $appointments = Appointment::get();

        return view('admin.prescriptions.index', compact('appointments'));
    }

    public function create()
    {
        abort_if(Gate::denies('prescription_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.prescriptions.create', compact('appointments'));
    }

    public function store(StorePrescriptionRequest $request)
    {
        $prescription = Prescription::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $prescription->id]);
        }

        return redirect()->route('admin.prescriptions.index');
    }

    public function edit(Prescription $prescription)
    {
        abort_if(Gate::denies('prescription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $prescription->load('appointment');

        return view('admin.prescriptions.edit', compact('appointments', 'prescription'));
    }

    public function update(UpdatePrescriptionRequest $request, Prescription $prescription)
    {
        $prescription->update($request->all());

        return redirect()->route('admin.prescriptions.index');
    }

    public function show(Prescription $prescription)
    {
        abort_if(Gate::denies('prescription_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prescription->load('appointment');

        return view('admin.prescriptions.show', compact('prescription'));
    }

    public function destroy(Prescription $prescription)
    {
        abort_if(Gate::denies('prescription_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $prescription->delete();

        return back();
    }

    public function massDestroy(MassDestroyPrescriptionRequest $request)
    {
        $prescriptions = Prescription::find(request('ids'));

        foreach ($prescriptions as $prescription) {
            $prescription->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('prescription_create') && Gate::denies('prescription_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Prescription();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
