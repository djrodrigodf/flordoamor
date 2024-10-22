<?php

namespace App\Livewire\Admin;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Patient;
use App\Models\Product;
use App\Models\Shipping;
use Livewire\Component;
use Mary\Traits\Toast;

class InvoiceDetail extends Component
{
    use Toast;
    public $id;
    public $productSelected;
    public $paymentMethod;
    public $headerTable = [];
    public $invoice = [];
    public $patient = [];
    public $products = [];
    public $itensInvoice = [];
    public $newItem = [];
    public $newProduct = false;
    public $shippingDrawer = false;
    public $paymentDrawer = false;
    public $shipping = [];
    public $shipp = [];
    /**
     * @var true
     */
    public bool $isEditShipp = false;

    public function mount() {
        $this->products = Product::get();
    }

    public function saveInvoice() {
        $this->invoice['payment_method'] = $this->paymentMethod;
        $this->invoice['status'] = 'Aguardando Pagamento';
        $this->invoice->save();

        $this->paymentDrawer = false;
    }

    public function getHeaders()
    {
        $this->headerTable = [
            ['key' => 'product.name', 'label' => 'Produto'],
            ['key' => 'product.description', 'label' => 'Detalhes'],
            ['key' => 'product.size', 'label' => 'Tamanho'],
            ['key' => 'quantity', 'label' => 'Quantidade'],
            ['key' => 'price', 'label' => 'Valor unitario'],
        ];
    }

    public function EditShipp() {
        $this->shipp = [
            'shipping_cost' => $this->shipping['shipping_cost'],
            'carrier' => $this->shipping['carrier'],
        ];
        $this->shippingDrawer = true;
        $this->isEditShipp = true;
    }

    public function saveShipp() {
        $this->validate([
            'shipp.carrier' => 'required',
            'shipp.shipping_cost' => 'required',
        ],[
            'shipp.carrier.required' => 'Precisa de uma transportadora',
            'shipp.shipping_cost.required' => 'Valor do frete é obrigatorio',
        ]);

        $this->shipp['shipping_cost'] = str_replace(['.', ','], ['', '.'], $this->shipp['shipping_cost']);
        if ($this->isEditShipp) {
            $this->shipping->update($this->shipp);
        } else {
            Shipping::create(
                [
                    'invoice_id' => $this->id,
                    'carrier' => $this->shipp['carrier'],
                    'shipping_cost' => $this->shipp['shipping_cost'],
                ]
            );
        }



        $this->shipp = [];
        $this->success('Frete cadastrado com sucesso');
        $this->shippingDrawer = false;
    }

    public function searchProducts(string $value = '') {
        $this->products = Product::whereAny(
            [
                'name',
            ],
            'LIKE',
            "%$value%"
        )->get();
    }

    public function addProduct() {
        $this->validate([
            'productSelected' => 'required',
            'newItem.quantity' => 'required',
        ],
        [
            'productSelected.required' => 'Selecione o produto para adicionar',
            'newItem.quantity.required' => 'Adicione a quantidade desejada'
        ]);
        $product = Product::find($this->productSelected);

        $valor = str_replace(['.', ','], ['', '.'], $product->unit_price);

        $existe = InvoiceItem::where('product_id', $product->id)->where('invoice_id', $this->id);

        if ($existe->exists()) {
            $quantidade = $existe->first()->quantity + $this->newItem['quantity'];
            $existe->first()->update([
                'quantity' => $quantidade,
                'price' => $valor * $quantidade,
            ]);
        } else {
            InvoiceItem::create([
                'product_id' => $this->productSelected,
                'quantity' => $this->newItem['quantity'],
                'price' => $valor * $this->newItem['quantity'],
                'product_id' => $product->id,
                'invoice_id' => $this->id,
            ]);
        }




        $this->newItem = [];
        $this->productSelected = null;
        $this->success('Item adicionado com sucesso.');
    }

    public function generateInvoice() {
        $this->paymentDrawer = true;
    }

    public function deleteItem($id) {
            InvoiceItem::find($id)->delete();
        $this->success('Item removido com sucesso.');
    }

    public function render()
    {
        $this->shipping = Shipping::where('invoice_id', $this->id)->first();
        $this->getHeaders();
        $this->itensInvoice = InvoiceItem::where('invoice_id', $this->id)->get();
        $this->invoice = Invoice::find($this->id);
        $this->patient = Patient::find($this->invoice->patient_id);
        return view('livewire.admin.invoice-detail');
    }
}
