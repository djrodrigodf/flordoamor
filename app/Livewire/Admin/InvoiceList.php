<?php

namespace App\Livewire\Admin;

use App\Models\Invoice;
use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class InvoiceList extends Component
{
    use Toast;
    use WithPagination;

    public $search;
    public $patientSelected = [];
    public $ModalAddClient = false;
    public $patients = [];
    public bool $drawerForm = false;
    public $headerTable = [];

    public function mount()
    {
        $this->searchPatients();
    }

    public function createInvoice() {
        $this->validate([
            'patientSelected' => 'required',
        ],
        [
            'patientSelected.required' => 'Selecione um paciente para gerar o pedido'
        ]);

        $pedido = Invoice::create(
            ['patient_id' => $this->patientSelected, 'total_amount' => 0]
        );

        $this->patientSelected = null;
        $this->ModalAddClient = false;
        $this->redirect("/invoice/$pedido->id");
    }

    public function searchPatients(string $value = '')
    {

        $this->patients = Patient::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get();// <-- Adds selected option
    }

    public function getHeaders()
    {
        $this->headerTable = [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'patient.name', 'label' => 'Cliente'],
            ['key' => 'total', 'label' => 'Valor Total'],
            ['key' => 'status', 'label' => 'Status do Pedido'],
            ['key' => 'created_at', 'label' => 'Data de Criação'],
        ];
    }

    public function render()
    {
        $this->getHeaders();

        return view('livewire.admin.invoice-list', ['invoices' => $this->getInvoices()]);
    }

    public function getInvoices()
    {
        return Invoice::with('patient', 'items') // Carrega o relacionamento do cliente
        ->when($this->search, function ($query) {
            $query->whereHas('patient', function ($q) {
                $q->where('name', 'LIKE', "%$this->search%");
            });
        })
            ->paginate(10);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function detail($id)
    {
        return $this->redirect(route('invoice.detail', ['id' => $id]));
    }

    public function delete($id)
    {
        Invoice::find($id)->delete();
        $this->success('Fatura excluída com sucesso.');
    }
}
