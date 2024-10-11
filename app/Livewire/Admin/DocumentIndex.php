<?php

namespace App\Livewire\Admin;

use App\Models\Document;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class DocumentIndex extends Component
{
    use WithPagination;

    public $search;
    public $perPage = 10;

    protected $listeners = ['delete'];


    public function mount()
    {
//        abort_if(Gate::denies('document_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
    }

    public function render()
    {
        $query = Document::with(['patient'])
            ->when($this->search, function ($query) {
                $query->where('description', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc');

        $documents = $query->paginate($this->perPage);

        return view('livewire.admin.document-index', compact('documents'));
    }

    public function delete($id)
    {
        abort_if(Gate::denies('document_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $document = Document::findOrFail($id);
        $document->delete();

        session()->flash('message', 'Documento deletado com sucesso.');
    }
}
