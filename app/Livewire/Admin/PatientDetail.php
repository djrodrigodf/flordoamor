<?php

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\EmergencyContact;
use App\Models\History;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class PatientDetail extends Component
{
    use Toast;
    use WithFileUploads;

    public $id;
    public bool $showDrawerContact = false;
    public $contact = [];
    public $photoPerfil = null;
    public $showDrawerHistory = false;
    public $selectedTab = 'documents-tab';
    public $existContact = false;
    public $documents = [];
    public $myModal1 = false;
    public $newDocument = [];

    public $headerTable = [];
    public $newHistory = [];
    public $boolEditHistory = false;
    public $fileType = [
        ['id' => 'laudoe', 'name' => 'Laudo'],
        ['id' => 'documento', 'name' => 'Documento'],

    ];

    public function updatedPhotoPerfil() {
        $document = Document::create([
            'patient_id' => $this->id,
            'document_type' => 'foto'
        ]);


            $file = $this->photoPerfil;
            $document->addMedia($file->getRealPath())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection('foto');

        $this->success('Foto atualizada com sucesso!');
    }

    public function sendHistory() {
        $this->validate([
            'newHistory.title' => 'required',
            'newHistory.description' => 'required',
        ],
        [
            'newHistory.title.required' => 'Titulo é Obrigatorio',
            'newHistory.description.required' => 'Descrição é Obrigatorio',
        ]);

        if ($this->boolEditHistory) {
            $update = History::find($this->newHistory['id']);
            $update->title = $this->newHistory['title'];
            $update->description = $this->newHistory['description'];
            $update->save();
            $this->boolEditHistory = false;
        } else {
            History::create([
                'title' => $this->newHistory['title'],
                'description' => $this->newHistory['description'],
                'user_id' => Auth::id(),
                'patient_id' => $this->id,
            ]);
        }



        $this->showDrawerHistory = false;
        $this->newHistory = [];
        $this->success('Historico adicionado com sucesso!');

    }

    public function getHistorys() {

        $data = History::with('user')->where('patient_id', $this->id)->orderBy('id', 'desc')->get();
        return $data;
    }

    public function editHistory($id) {

        $data = History::find($id);
        $this->newHistory = $data->toArray();
        $this->showDrawerHistory = true;
        $this->boolEditHistory = true;
    }

    public function sendFile()
    {
        $this->validate([
            'newDocument.document_type' => 'required',
            'newDocument.file' => 'required',
        ],
        [
            'newDocument.document_type.required' => 'O campo tipo de documento é obrigatorio.',
            'newDocument.file' => 'O campo arquivo é obrigatorio.',
        ],
        );

        $document = Document::create([
            'patient_id' => $this->id,
            'document_type' => $this->newDocument['document_type'],
            'description' => $this->newDocument['description'] ?? null,
        ]);
        $type = $this->newDocument['document_type'];
        if ($this->newDocument['file']) {
            $file = $this->newDocument['file'];
            $document->addMedia($file->getRealPath())
                ->usingFileName($file->getClientOriginalName())
                ->toMediaCollection($type);
        }

        $this->success('Documento enviado com sucesso!');
        $this->newDocument = [];
        $this->myModal1 = false;
    }

    public function getHeaders()
    {
        $this->headerTable = [
            ['key' => 'id', 'label' => '#', 'sort' => true],
            ['key' => 'document_type', 'label' => 'Documento'],
            ['key' => 'description', 'label' => 'Descrição'],
            ['key' => 'files', 'label' => 'Arquivo'],
            ['key' => 'created_at', 'label' => 'Criado em'],
        ];
    }
    public function saveContact()
    {
        if ($this->existContact) {
            EmergencyContact::find($this->contact['id'])->update($this->contact);
            $this->success('Contato atualizado com sucesso!');
        } else {
            $this->contact['patient_id'] = $this->id;
            EmergencyContact::create($this->contact);
            $this->success('Contato cadastrado com sucesso!');
        }
        $this->showDrawerContact = false;
    }

    public function documents() {
        $this->documents = Document::whereNotIn('document_type', ['foto'])->where('patient_id', $this->id)->orderBy('id', 'desc')->get()->toArray();

    }

    public function render()
    {
        $foto = Document::with('media')->where('document_type', 'foto')->where('patient_id', $this->id)->orderBy('id', 'desc')->first();
        $this->documents();
        $this->getHeaders();
        $patient = Patient::find($this->id);
        $contactExists = EmergencyContact::where('patient_id', $patient->id);
        if ($contactExists->exists()) {
            $this->existContact = true;
            $this->contact = $contactExists->first()->toArray();
        } else {
            $this->contact = [];
        }
        return view('livewire.admin.patient-detail', ['patient' => $patient, 'historys' => $this->getHistorys(), 'foto' => $foto]);
    }
}
