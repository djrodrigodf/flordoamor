<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyMedicalReportRequest;
use App\Http\Requests\StoreMedicalReportRequest;
use App\Http\Requests\UpdateMedicalReportRequest;
use App\Models\Appointment;
use App\Models\MedicalReport;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MedicalReportController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('medical_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MedicalReport::with(['appointment'])->select(sprintf('%s.*', (new MedicalReport)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'medical_report_show';
                $editGate = 'medical_report_edit';
                $deleteGate = 'medical_report_delete';
                $crudRoutePart = 'medical-reports';

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

            $table->editColumn('report_type', function ($row) {
                return $row->report_type ? MedicalReport::REPORT_TYPE_SELECT[$row->report_type] : '';
            });
            $table->editColumn('file', function ($row) {
                if (! $row->file) {
                    return '';
                }
                $links = [];
                foreach ($row->file as $media) {
                    $links[] = '<a href="'.$media->getUrl().'" target="_blank">'.trans('global.downloadFile').'</a>';
                }

                return implode(', ', $links);
            });

            $table->rawColumns(['actions', 'placeholder', 'appointment', 'file']);

            return $table->make(true);
        }

        $appointments = Appointment::get();

        return view('admin.medicalReports.index', compact('appointments'));
    }

    public function create()
    {
        abort_if(Gate::denies('medical_report_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.medicalReports.create', compact('appointments'));
    }

    public function store(StoreMedicalReportRequest $request)
    {
        $medicalReport = MedicalReport::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $medicalReport->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $medicalReport->id]);
        }

        return redirect()->route('admin.medical-reports.index');
    }

    public function edit(MedicalReport $medicalReport)
    {
        abort_if(Gate::denies('medical_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $medicalReport->load('appointment');

        return view('admin.medicalReports.edit', compact('appointments', 'medicalReport'));
    }

    public function update(UpdateMedicalReportRequest $request, MedicalReport $medicalReport)
    {
        $medicalReport->update($request->all());

        if (count($medicalReport->file) > 0) {
            foreach ($medicalReport->file as $media) {
                if (! in_array($media->file_name, $request->input('file', []))) {
                    $media->delete();
                }
            }
        }
        $media = $medicalReport->file->pluck('file_name')->toArray();
        foreach ($request->input('file', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $medicalReport->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
            }
        }

        return redirect()->route('admin.medical-reports.index');
    }

    public function show(MedicalReport $medicalReport)
    {
        abort_if(Gate::denies('medical_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $medicalReport->load('appointment');

        return view('admin.medicalReports.show', compact('medicalReport'));
    }

    public function destroy(MedicalReport $medicalReport)
    {
        abort_if(Gate::denies('medical_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $medicalReport->delete();

        return back();
    }

    public function massDestroy(MassDestroyMedicalReportRequest $request)
    {
        $medicalReports = MedicalReport::find(request('ids'));

        foreach ($medicalReports as $medicalReport) {
            $medicalReport->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('medical_report_create') && Gate::denies('medical_report_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new MedicalReport;
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
