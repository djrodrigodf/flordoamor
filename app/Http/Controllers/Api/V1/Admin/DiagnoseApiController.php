<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDiagnosiRequest;
use App\Http\Requests\UpdateDiagnosiRequest;
use App\Http\Resources\Admin\DiagnosiResource;
use App\Models\Diagnosi;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class DiagnoseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('diagnosi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DiagnosiResource(Diagnosi::with(['appointment'])->get());
    }

    public function store(StoreDiagnosiRequest $request)
    {
        $diagnosi = Diagnosi::create($request->all());

        return (new DiagnosiResource($diagnosi))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Diagnosi $diagnosi)
    {
        abort_if(Gate::denies('diagnosi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DiagnosiResource($diagnosi->load(['appointment']));
    }

    public function update(UpdateDiagnosiRequest $request, Diagnosi $diagnosi)
    {
        $diagnosi->update($request->all());

        return (new DiagnosiResource($diagnosi))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Diagnosi $diagnosi)
    {
        abort_if(Gate::denies('diagnosi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $diagnosi->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
