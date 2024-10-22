<?php

namespace App\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class ProductList extends Component
{
    use Toast;
    use WithPagination;

    public $name;
    public $description;
    public $category;
    public $size;
    public $stock_quantity;
    public $unit_price;

    public $productId;

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
            ['key' => 'category', 'label' => 'Categoria'],
            ['key' => 'size', 'label' => 'Tamanho'],
            ['key' => 'stock_quantity', 'label' => 'Quantidade em Estoque'],
            ['key' => 'unit_price', 'label' => 'Valor Unitário'],
        ];
    }

    public function render()
    {
        $this->getHeaders();

        return view('livewire.admin.product-list', ['products' => $this->getProducts()]);
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->category = '';
        $this->size = '';
        $this->stock_quantity = '';
        $this->unit_price = '';
        $this->isEditMode = false;
        $this->productId = null;
        $this->resetErrorBag();
    }

    public function store()
    {
        $this->validate($this->rules(), $this->rulesMessages(), $this->rulesAttributes());

        Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'size' => $this->size,
            'stock_quantity' => $this->stock_quantity,
            'unit_price' => $this->unit_price,
        ]);

        $this->successMessage('Produto criado com sucesso.');
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

    public function getProducts()
    {
        return Product::when($this->search, function ($query) {
            $query->whereAny(
                [
                    'name',
                    'category',
                    'size',
                ],
                'LIKE',
                "%$this->search%"
            );
        })->paginate(50);
    }

    public function edit($id = null)
    {
        $this->resetErrorBag();
        if ($id) {
            $product = Product::findOrFail($id);
            $this->productId = $product->id;
            $this->name = $product->name;
            $this->description = $product->description;
            $this->category = $product->category;
            $this->size = $product->size;
            $this->stock_quantity = $product->stock_quantity;
            $this->unit_price = $product->unit_price;
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

        $product = Product::find($this->productId);
        $product->update([
            'name' => $this->name,
            'description' => $this->description,
            'category' => $this->category,
            'size' => $this->size,
            'stock_quantity' => $this->stock_quantity,
            'unit_price' => $this->unit_price,
        ]);

        $this->successMessage('Produto atualizado com sucesso.');
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->drawerForm = false;
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        $this->successMessage('Produto excluído com sucesso.');
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'category' => 'required',
            'stock_quantity' => 'required',
            'unit_price' => 'required',
        ];
    }

    public function rulesMessages()
    {
        return [
            'name.required' => 'O nome do produto é obrigatório.',
            'category.required' => 'A categoria do produto é obrigatória.',
            'stock_quantity.required' => 'A quantidade em estoque é obrigatória.',
            'unit_price.required' => 'O valor unitário é obrigatório.',
        ];
    }

    public function rulesAttributes()
    {
        return [
            'name' => 'Nome do Produto',
            'category' => 'Categoria',
            'stock_quantity' => 'Quantidade em Estoque',
            'unit_price' => 'Valor Unitário',
        ];
    }
}
