<?php

namespace App\Livewire\Admin;

use App\Models\Patient;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class PatientComponent extends Component
{
    use Toast;
    use WithPagination;

    public $name;

    public $email;

    public $phone;

    public $birth_date;

    public $rg;
    public $ssp;

    public $cpf;

    public $address;

    public $number;

    public $complement;

    public $neighborhood;

    public $city;

    public $state;
    public bool $blockBairro = true;

    public $postal_code;

    public $observations;

    public $patientId;

    public $isEditMode = false;

    public $search;

    public bool $drawerForm = false;

    public $headerTable = [];

    public string $toastPosition = 'toast-bottom';

    public function successMessage($message)
    {
        $this->success($message, position: $this->toastPosition);
    }

    public function updatedCpf($value)
    {
        if (strlen($value) === 14) {
            $cpf = preg_replace('/\D/', '', $value);
            $findDuplicate = Patient::where('cpf', $cpf)->exists();
            if ($findDuplicate) {
                $this->error('CPF já está cadastrado!');
                $this->cpf = null;
            }
        }
    }

    public function getHeaders()
    {
        $this->headerTable = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => 'Nome'],
            ['key' => 'cpf', 'label' => 'CPF'],
            ['key' => 'email', 'label' => 'E-mail'],
            ['key' => 'phone', 'label' => 'Telefone'],
            ['key' => 'city', 'label' => 'Cidade'],
        ];
    }

    public function render()
    {
        $this->getHeaders();

        return view('livewire.admin.patient-component', ['patients' => $this->getPatients()]);
    }

    public function detail($id) {
        return $this->redirect(route('patient.detail', ['id' => $id]));
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->birth_date = '';
        $this->rg = '';
        $this->ssp = '';
        $this->cpf = '';
        $this->address = '';
        $this->number = '';
        $this->complement = '';
        $this->neighborhood = '';
        $this->city = '';
        $this->state = '';
        $this->postal_code = '';
        $this->observations = '';
        $this->isEditMode = false;
        $this->patientId = null;
        $this->resetErrorBag();
    }

    public function store()
    {

        $this->validate($this->rules(), $this->rulesMessages(), $this->rulesAttributes());

        Patient::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => !empty($this->birth_date) ? $this->birth_date : null,
            'rg' => $this->rg,
            'ssp' => $this->ssp,
            'cpf' => $this->cpf,
            'address' => $this->address,
            'number' => $this->number ? $this->number : 'S/N',
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'observations' => $this->observations,
        ]);

        $this->successMessage('Patient Created Successfully.');
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

    public function getPatients()
    {
        return Patient::when($this->search, function ($query) {
            $query->whereAny(
                [
                    'name',
                    'email',
                    'phone',
                    'cpf',
                ],
                'LIKE',
                "%$this->search%"
            );
        })->paginate(10);
    }

    public function edit($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $patient = Patient::findOrFail($id);
            $this->patientId = $patient->id;
            $this->name = $patient->name;
            $this->email = $patient->email;
            $this->phone = $patient->phone;
            $this->birth_date = $patient->birth_date;
            $this->rg = $patient->rg;
            $this->cpf = $patient->cpf;
            $this->address = $patient->address;
            $this->number = $patient->number;
            $this->complement = $patient->complement;
            $this->neighborhood = $patient->neighborhood;
            $this->city = $patient->city;
            $this->state = $patient->state;
            $this->postal_code = $patient->postal_code;
            $this->observations = $patient->observations;
            $this->isEditMode = true;
            $this->drawerForm = true;
        } else {
            $this->resetInputFields();
            $this->isEditMode = false;
            $this->drawerForm = true;
        }
    }

    public function update()
    {

        $this->validate($this->rules(), $this->rulesMessages(), $this->rulesAttributes());

        $patient = Patient::find($this->patientId);
        $patient->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'birth_date' => $this->birth_date,
            'rg' => $this->rg,
            'address' => $this->address,
            'number' => $this->number,
            'complement' => $this->complement,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'postal_code' => $this->postal_code,
            'observations' => $this->observations,
        ]);

        $this->successMessage('Patient Updated Successfully.');
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
        Patient::find($id)->delete();
        $this->successMessage('Patient Deleted Successfully.');
    }

    public function updatedPostalCode($value)
    {
        $getPostalCode = Http::get("https://viacep.com.br/ws/$value/json/");
        if ($getPostalCode->status() == 200) {
            $resp = $getPostalCode->json();
            if (isset($resp['erro'])) {
                $this->error('Cep não encontrado');
                $this->postal_code = null;
                $this->blockBairro = true;
            } else {
                $this->successMessage('Endereço localizado. Verifique os detalhes e preencha informações adicionais, se necessário!');
                $this->address = $resp['logradouro'];
                $this->neighborhood = $resp['bairro'];
                $this->city = $resp['localidade'];
                $this->state = $resp['uf'];
                if ($this->neighborhood == null) {
                    $this->blockBairro = false;
                }
            }
        }
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:patients,email',
            'phone' => 'required|min:14',
            'cpf' => ['required', 'formato_cpf', 'cpf'],
            'birth_date' => 'nullable',
            'postal_code' => 'required',
        ];
    }

    public function rulesMessages()
    {
        return [
            'cpf_format' => 'O CPF informado não é válido.',
        ];
    }

    public function rulesAttributes()
    {
        return [
            'name' => 'Nome',
            'email' => 'E-mail',
            'phone' => 'Telefone',
            'cpf' => 'CPF',
            'birth_date' => 'Data de Nascimento',
            'city' => 'Cidade',
        ];
    }
}
