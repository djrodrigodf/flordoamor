<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreTreatmentRequest;
use App\Http\Requests\UpdateTreatmentRequest;
use App\Http\Resources\Admin\TreatmentResource;
use App\Models\Treatment;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TreatmentApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('treatment_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TreatmentResource(Treatment::with(['patient'])->get());
    }

    public function store(StoreTreatmentRequest $request)
    {
        $treatment = Treatment::create($request->all());

        return (new TreatmentResource($treatment))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Treatment $treatment)
    {
        abort_if(Gate::denies('treatment_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TreatmentResource($treatment->load(['patient']));
    }

    public function update(UpdateTreatmentRequest $request, Treatment $treatment)
    {
        $treatment->update($request->all());

        return (new TreatmentResource($treatment))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Treatment $treatment)
    {
        abort_if(Gate::denies('treatment_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $treatment->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
