<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyEmergencyContactRequest;
use App\Http\Requests\StoreEmergencyContactRequest;
use App\Http\Requests\UpdateEmergencyContactRequest;
use App\Models\EmergencyContact;
use App\Models\Patient;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class EmergencyContactController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('emergency_contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = EmergencyContact::with(['patient'])->select(sprintf('%s.*', (new EmergencyContact)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'emergency_contact_show';
                $editGate      = 'emergency_contact_edit';
                $deleteGate    = 'emergency_contact_delete';
                $crudRoutePart = 'emergency-contacts';

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

            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('relationship', function ($row) {
                return $row->relationship ? $row->relationship : '';
            });
            $table->editColumn('phone', function ($row) {
                return $row->phone ? $row->phone : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'patient']);

            return $table->make(true);
        }

        $patients = Patient::get();

        return view('admin.emergencyContacts.index', compact('patients'));
    }

    public function create()
    {
        abort_if(Gate::denies('emergency_contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.emergencyContacts.create', compact('patients'));
    }

    public function store(StoreEmergencyContactRequest $request)
    {
        $emergencyContact = EmergencyContact::create($request->all());

        return redirect()->route('admin.emergency-contacts.index');
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        abort_if(Gate::denies('emergency_contact_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $emergencyContact->load('patient');

        return view('admin.emergencyContacts.edit', compact('emergencyContact', 'patients'));
    }

    public function update(UpdateEmergencyContactRequest $request, EmergencyContact $emergencyContact)
    {
        $emergencyContact->update($request->all());

        return redirect()->route('admin.emergency-contacts.index');
    }

    public function show(EmergencyContact $emergencyContact)
    {
        abort_if(Gate::denies('emergency_contact_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emergencyContact->load('patient');

        return view('admin.emergencyContacts.show', compact('emergencyContact'));
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        abort_if(Gate::denies('emergency_contact_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $emergencyContact->delete();

        return back();
    }

    public function massDestroy(MassDestroyEmergencyContactRequest $request)
    {
        $emergencyContacts = EmergencyContact::find(request('ids'));

        foreach ($emergencyContacts as $emergencyContact) {
            $emergencyContact->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
