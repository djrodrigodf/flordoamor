<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyTreatmentRequest;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Models\Patient;
use App\Models\Treatment;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TreatmentController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('treatment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Treatment::with(['patient'])->select(sprintf('%s.*', (new Treatment)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'treatment_show';
                $editGate = 'treatment_edit';
                $deleteGate = 'treatment_delete';
                $crudRoutePart = 'treatments';

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
            $table->addColumn('patient_name', function ($row) {
                return $row->patient ? $row->patient->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'patient']);

            return $table->make(true);
        }

        $patients = Patient::get();

        return view('admin.treatments.index', compact('patients'));
    }

    public function create()
    {
        abort_if(Gate::denies('treatment_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.treatments.create', compact('patients'));
    }

    public function store(StoreTreatmentRequest $request)
    {
        $treatment = Treatment::create($request->all());

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $treatment->id]);
        }

        return redirect()->route('admin.treatments.index');
    }

    public function edit(Treatment $treatment)
    {
        abort_if(Gate::denies('treatment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $treatment->load('patient');

        return view('admin.treatments.edit', compact('patients', 'treatment'));
    }

    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        $treatment->update($request->all());

        return redirect()->route('admin.treatments.index');
    }

    public function show(Treatment $treatment)
    {
        abort_if(Gate::denies('treatment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $treatment->load('patient');

        return view('admin.treatments.show', compact('treatment'));
    }

    public function destroy(Treatment $treatment)
    {
        abort_if(Gate::denies('treatment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $treatment->delete();

        return back();
    }

    public function massDestroy(MassDestroyTreatmentRequest $request)
    {
        $treatments = Treatment::find(request('ids'));

        foreach ($treatments as $treatment) {
            $treatment->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('treatment_create') && Gate::denies('treatment_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model = new Treatment;
        $model->id = $request->input('crud_id', 0);
        $model->exists = true;
        $media = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
