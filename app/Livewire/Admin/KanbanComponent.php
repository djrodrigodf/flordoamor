<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\Invoice;
use Carbon\Carbon;
use Livewire\Component;
use Mary\Traits\Toast;

class KanbanComponent extends Component
{
    use Toast;

    public $orders = [];
    /**
     * @var true
     */
    public bool $pedidoPreparacaoDrawer = false;
    public string $titleDrawer;
    public $selectKanban;
    public $tracking_number;
    public $draggingOrder = null;
    public $detailModal = false;

    public $headerTable = [
        ['key' => 'product.name', 'label' => 'Produto'],
        ['key' => 'product.description', 'label' => 'Detalhes'],
        ['key' => 'product.size', 'label' => 'Tamanho'],
        ['key' => 'quantity', 'label' => 'Quantidade'],
        ['key' => 'price', 'label' => 'Valor unitario'],
    ];

    public $historic = [];

    public function getHistoric($id)
    {
        // Use the correct subject_type and utilize eager loading for efficiency
        $this->historic = AuditLog::with('user')
            ->where('subject_type', "App\Models\Invoice#$id")
            ->where('subject_id', $id)
            ->get()
            ->map(function ($log) {

                return [
                    'id'         => $log->subject_id,
                    'status'     => $log->properties['status'] ?? null,
                    'created_at' => $log->created_at,
                    'user'       => $log->user->name,
                ];
            })
            ->toArray();

    }
    public function getInvoices()
    {
        $this->orders = Invoice::with(['patient', 'items', 'shipping'])->whereNotIn('status', ['Rascunho'])->get();
    }

    public function revogarPagamento()
    {
        $this->selectKanban->update(['status' => 'Aguardando Pagamento']);
        $this->pedidoPreparacaoDrawer = false;
        $this->getInvoices();
    }

    public function confirmarPagamento()
    {
        $this->selectKanban->update(['status' => 'Entrada de Pedido']);
        $this->pedidoPreparacaoDrawer = false;
        $this->getInvoices();
    }

    public function sendShip()
    {
        $this->selectKanban->update(['status' => 'Pedido pronto para Entrega']);
        $this->selectKanban->shipping->update(['tracking_number' => $this->tracking_number]);
        $this->pedidoPreparacaoDrawer = false;
        $this->getInvoices();
    }

    public function openModal($id)
    {
        $this->selectKanban = Invoice::with(['patient', 'items', 'shipping'])->find($id);
        $this->getHistoric($id);
        $this->detailModal = true;

    }

    public function updateOrderStatus($orderId, $newStatus)
    {
        $this->tracking_number = null;
        $getInvoice = Invoice::find($orderId);

        if ($newStatus == 'Entrada de Pedido') {
            $this->pedidoPreparacaoDrawer = true;
            $this->titleDrawer = 'Entrada de Pedido';
            $this->selectKanban = $getInvoice;
            return false;
        }

        if ($newStatus == 'Aguardando Pagamento') {
            $this->pedidoPreparacaoDrawer = true;
            $this->titleDrawer = 'Aguardando Pagamento';
            $this->selectKanban = $getInvoice;
            return false;
        }

        if ($newStatus == 'Pedido em Preparacao') {
            $getInvoice->update(['status' => 'Pedido em Preparacao']);
            return true;
        }

        if ($newStatus == 'Pedido pronto para Entrega') {
            $this->pedidoPreparacaoDrawer = true;
            $this->titleDrawer = 'pronto para Entrega';
            $this->selectKanban = $getInvoice;
            return true;
        }

        if ($newStatus == 'Pedido Entregue') {
            $getInvoice->update(['status' => 'Pedido Entregue']);
            return true;
        }

        if ($valid) {
            $this->error('Voce não pode mover esse card');
            return false;
        }

        foreach ($this->orders as &$order) {
            if ($order['id'] == $orderId) {
                $order['status'] = $newStatus;
                break;
            }
        }

        // Atualiza a lista de pedidos
        $this->draggingOrder = null;
    }

    public function setDraggingOrder($orderId)
    {
        dd($orderId);
        $this->draggingOrder = $orderId;
    }

    public function render()
    {
        return view('livewire.admin.kanban-component', [
            'invoices' => $this->getInvoices()
        ]);
    }
}
