<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyInsuranceRequest;
use App\Http\Requests\StoreInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Models\Insurance;
use App\Models\Patient;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class InsuranceController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('insurance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Insurance::with(['patient'])->select(sprintf('%s.*', (new Insurance)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'insurance_show';
                $editGate      = 'insurance_edit';
                $deleteGate    = 'insurance_delete';
                $crudRoutePart = 'insurances';

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

            $table->editColumn('insurance_name', function ($row) {
                return $row->insurance_name ? $row->insurance_name : '';
            });
            $table->editColumn('policy_number', function ($row) {
                return $row->policy_number ? $row->policy_number : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'patient']);

            return $table->make(true);
        }

        $patients = Patient::get();

        return view('admin.insurances.index', compact('patients'));
    }

    public function create()
    {
        abort_if(Gate::denies('insurance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.insurances.create', compact('patients'));
    }

    public function store(StoreInsuranceRequest $request)
    {
        $insurance = Insurance::create($request->all());

        return redirect()->route('admin.insurances.index');
    }

    public function edit(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $insurance->load('patient');

        return view('admin.insurances.edit', compact('insurance', 'patients'));
    }

    public function update(UpdateInsuranceRequest $request, Insurance $insurance)
    {
        $insurance->update($request->all());

        return redirect()->route('admin.insurances.index');
    }

    public function show(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurance->load('patient');

        return view('admin.insurances.show', compact('insurance'));
    }

    public function destroy(Insurance $insurance)
    {
        abort_if(Gate::denies('insurance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $insurance->delete();

        return back();
    }

    public function massDestroy(MassDestroyInsuranceRequest $request)
    {
        $insurances = Insurance::find(request('ids'));

        foreach ($insurances as $insurance) {
            $insurance->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
