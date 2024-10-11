<?php

namespace App\Livewire\Admin;

use App\Models\Doctor;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class DoctorComponent extends Component
{
    use Toast;
    use WithPagination;

    public $name;

    public $specialty;

    public $crm;

    public $phone;

    public $email;

    public $doctorId;

    public $isEditMode = false;

    public $search;

    public bool $drawerForm = false;

    public $headerTable = [];

    public string $toastPosition = 'toast-bottom';

    public function successMessage($message)
    {
        $this->success($message, position: $this->toastPosition);
    }

    public function getHeaders()
    {
        $this->headerTable = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'specialty', 'label' => 'Especialidade'],
            ['key' => 'crm', 'label' => 'CRM'],
            ['key' => 'phone', 'label' => 'Telefone'],
            ['key' => 'email', 'label' => 'E-mail'],
        ];
    }

    public function render()
    {
        $this->getHeaders();

        return view('livewire.admin.doctor-component', ['doctors' => $this->getDoctors()]);
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->specialty = '';
        $this->crm = '';
        $this->phone = '';
        $this->email = '';
        $this->isEditMode = false;
        $this->doctorId = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate($this->rules(), $this->rulesMessages(), $this->rulesAttributes());

        Doctor::create([
            'name' => $this->name,
            'specialty' => $this->specialty,
            'crm' => $this->crm,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->successMessage('Doctor Created Successfully.');
        $this->resetInputFields();
        $this->drawerForm = false;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function clear()
    {
        $this->drawerForm = false;
        $this->resetInputFields();
    }

    public function getDoctors()
    {
        return Doctor::when($this->search, function ($query) {
            $query->whereAny(
                [
                    'name',
                    'specialty',
                    'crm',
                    'phone',
                    'email',
                ],
                'LIKE',
                "%$this->search%"
            );
        })->paginate(10);
    }

    public function edit($id = null)
    {
        if ($id) {
            $doctor = Doctor::findOrFail($id);
            $this->doctorId = $doctor->id;
            $this->name = $doctor->name;
            $this->specialty = $doctor->specialty;
            $this->crm = $doctor->crm;
            $this->phone = $doctor->phone;
            $this->email = $doctor->email;
            $this->isEditMode = true;
            $this->drawerForm = true;
        } else {
            $this->resetInputFields();
            $this->isEditMode = false;
            $this->drawerForm = true;
        }
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'specialty' => 'required',
            'crm' => 'required',
            'phone' => 'required|min:14',
            'email' => 'required|email',
        ];
    }

    public function rulesMessages()
    {
        return [
            'name.required' => 'O campo Nome é obrigatório.',
            'specialty.required' => 'O campo Especialidade é obrigatório.',
            'crm.required' => 'O campo CRM é obrigatório.',
            'phone.required' => 'O campo Telefone é obrigatório.',
            'phone.min' => 'Informe um telefone válido.',
            'email.required' => 'O campo E-mail é obrigatório.',
            'email.email' => 'Informe um e-mail válido.',
        ];
    }

    public function rulesAttributes()
    {
        return [
            'name' => 'Nome',
            'specialty' => 'Especialidade',
            'crm' => 'CRM',
            'phone' => 'Telefone',
            'email' => 'E-mail',
        ];
    }

    public function update()
    {
        $this->validate($this->rules(), $this->rulesMessages(), $this->rulesAttributes());

        $doctor = Doctor::find($this->doctorId);
        $doctor->update([
            'name' => $this->name,
            'specialty' => $this->specialty,
            'crm' => $this->crm,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);

        $this->successMessage('Doctor Updated Successfully.');
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->drawerForm = false;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules(), $this->rulesMessages(), $this->rulesAttributes());
    }

    public function delete($id)
    {
        Doctor::find($id)->delete();
        $this->successMessage('Doctor Deleted Successfully.');
    }
}
