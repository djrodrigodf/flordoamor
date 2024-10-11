<?php

namespace App\Livewire\Admin;

use App\Models\Document;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DocumentCreate extends Component
{
    use WithFileUploads;

    public $patient_id;
    public $document_type;
    public $description;
    public $file;

    public $patients;

    protected $rules = [
        'patient_id' => 'required|exists:patients,id',
        'document_type' => 'required|string',
        'description' => 'nullable|string',
        'file' => 'nullable|file|max:204800', // 200MB
    ];

    public function mount()
    {
//        abort_if(Gate::denies('document_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $this->patients = Patient::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
    }

    public function updatedFile()
    {
        $this->validate([
            'file' => 'nullable|file|max:204800', // 200MB
        ]);
    }

    public function submit()
    {
        $this->validate();

        $document = Document::create([
            'patient_id' => $this->patient_id,
            'document_type' => $this->document_type,
            'description' => $this->description,
        ]);

        if ($this->file) {
            $document->addMedia($this->file->getRealPath())
                ->usingFileName($this->file->getClientOriginalName())
                ->toMediaCollection('file');
        }

        session()->flash('message', 'Documento criado com sucesso.');

    }

    public function render()
    {
        return view('livewire.admin.document-create');
    }
}
