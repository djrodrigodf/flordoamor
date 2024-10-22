<div>
    <x-header title="Produtos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo Produto" wire:click="edit()" responsive icon="o-plus-circle" class="btn-primary"/>
        </x-slot:actions>
    </x-header>

    @if($drawerForm)
        <x-drawer wire:model="drawerForm" title="{{$isEditMode ? 'Editar Produto' : 'Adicionar Produto'}}" right separator with-close-button class="lg:w-1/3">
            <div>
                <x-input placeholder="Nome do Produto" wire:model.live="name" />
                <x-textarea placeholder="Descrição" wire:model.live="description" class="mt-4"/>
                <x-input placeholder="Categoria" wire:model.live="category" class="mt-4" />
                <x-input placeholder="Tamanho (ml/g)" wire:model.live="size" class="mt-4"/>
                <x-input placeholder="Quantidade em Estoque" wire:model.live="stock_quantity" type="number" class="mt-4"/>


                <x-input placeholder="Valor Unitário" wire:model.live="unit_price" x-mask:dynamic="$money($input, ',')" class="mt-4" />

            </div>

            <x-slot:actions>
                <x-button label="Cancelar" icon="o-x-mark" wire:click="clear" spinner class="danger"/>
                <x-button label="{{$isEditMode ? 'Editar' : 'Criar'}}" icon="o-plus-circle" class="btn-primary" wire:click="{{$isEditMode ? 'update' : 'store'}}"/>
            </x-slot:actions>
        </x-drawer>
    @endif

    <x-card>
        <x-table :headers="$headerTable" :rows="$products" with-pagination striped>
            @scope('actions', $product)
            <div class="flex">
                <x-button icon="o-pencil-square" wire:click="edit({{ $product->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                <x-button icon="o-trash" wire:click="delete({{ $product->id }})" spinner class="btn-ghost btn-sm text-red-500"/>
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
