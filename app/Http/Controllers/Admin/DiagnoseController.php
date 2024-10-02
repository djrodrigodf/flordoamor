<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDiagnosiRequest;
use App\Http\Requests\StoreDiagnosiRequest;
use App\Http\Requests\UpdateDiagnosiRequest;
use App\Models\Appointment;
use App\Models\Diagnosi;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DiagnoseController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('diagnosi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Diagnosi::with(['appointment'])->select(sprintf('%s.*', (new Diagnosi)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'diagnosi_show';
                $editGate      = 'diagnosi_edit';
                $deleteGate    = 'diagnosi_delete';
                $crudRoutePart = 'diagnosis';

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

        return view('admin.diagnosis.index', compact('appointments'));
    }

    public function create()
    {
        abort_if(Gate::denies('diagnosi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.diagnosis.create', compact('appointments'));
    }

    public function store(StoreDiagnosiRequest $request)
    {
        $diagnosi = Diagnosi::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $diagnosi->id]);
        }

        return redirect()->route('admin.diagnosis.index');
    }

    public function edit(Diagnosi $diagnosi)
    {
        abort_if(Gate::denies('diagnosi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appointments = Appointment::pluck('appointment_date', 'id')->prepend(trans('global.pleaseSelect'), '');

        $diagnosi->load('appointment');

        return view('admin.diagnosis.edit', compact('appointments', 'diagnosi'));
    }

    public function update(UpdateDiagnosiRequest $request, Diagnosi $diagnosi)
    {
        $diagnosi->update($request->all());

        return redirect()->route('admin.diagnosis.index');
    }

    public function show(Diagnosi $diagnosi)
    {
        abort_if(Gate::denies('diagnosi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $diagnosi->load('appointment');

        return view('admin.diagnosis.show', compact('diagnosi'));
    }

    public function destroy(Diagnosi $diagnosi)
    {
        abort_if(Gate::denies('diagnosi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $diagnosi->delete();

        return back();
    }

    public function massDestroy(MassDestroyDiagnosiRequest $request)
    {
        $diagnosis = Diagnosi::find(request('ids'));

        foreach ($diagnosis as $diagnosi) {
            $diagnosi->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('diagnosi_create') && Gate::denies('diagnosi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Diagnosi();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
