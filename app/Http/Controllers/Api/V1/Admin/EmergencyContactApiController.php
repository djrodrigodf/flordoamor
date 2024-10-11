<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmergencyContactRequest;
use App\Http\Requests\UpdateEmergencyContactRequest;
use App\Http\Resources\Admin\EmergencyContactResource;
use App\Models\EmergencyContact;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class EmergencyContactApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('emergency_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmergencyContactResource(EmergencyContact::with(['patient'])->get());
    }

    public function store(StoreEmergencyContactRequest $request)
    {
        $emergencyContact = EmergencyContact::create($request->all());

        return (new EmergencyContactResource($emergencyContact))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmergencyContact $emergencyContact)
    {
        abort_if(Gate::denies('emergency_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmergencyContactResource($emergencyContact->load(['patient']));
    }

    public function update(UpdateEmergencyContactRequest $request, EmergencyContact $emergencyContact)
    {
        $emergencyContact->update($request->all());

        return (new EmergencyContactResource($emergencyContact))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        abort_if(Gate::denies('emergency_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emergencyContact->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
