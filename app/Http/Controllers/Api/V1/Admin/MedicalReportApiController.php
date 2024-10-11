<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreMedicalReportRequest;
use App\Http\Requests\UpdateMedicalReportRequest;
use App\Http\Resources\Admin\MedicalReportResource;
use App\Models\MedicalReport;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class MedicalReportApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('medical_report_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MedicalReportResource(MedicalReport::with(['appointment'])->get());
    }

    public function store(StoreMedicalReportRequest $request)
    {
        $medicalReport = MedicalReport::create($request->all());

        foreach ($request->input('file', []) as $file) {
            $medicalReport->addMedia(storage_path('tmp/uploads/'.basename($file)))->toMediaCollection('file');
        }

        return (new MedicalReportResource($medicalReport))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(MedicalReport $medicalReport)
    {
        abort_if(Gate::denies('medical_report_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new MedicalReportResource($medicalReport->load(['appointment']));
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

        return (new MedicalReportResource($medicalReport))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(MedicalReport $medicalReport)
    {
        abort_if(Gate::denies('medical_report_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $medicalReport->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
