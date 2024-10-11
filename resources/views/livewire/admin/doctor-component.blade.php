<div>
    <x-header title="Médicos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Pesquisar..." wire:model.live.debounce.500ms="search" clearable icon="o-magnifying-glass"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo" wire:click="edit()" responsive icon="o-funnel" class="btn-primary"/>
        </x-slot:actions>
    </x-header>

    <x-drawer wire:model="drawerForm" title="{{$isEditMode ? 'Editar Médico' : 'Adicionar Médico'}}" right separator with-close-button class="lg:w-1/3 md:w-2/3 sm:w-full">

        <div>
            <x-input placeholder="Nome" wire:model.live="name"/>
            <x-input placeholder="Especialidade" wire:model.live="specialty" class="mt-4"/>
            <x-input placeholder="CRM (Ex: 1234567)" wire:model.live="crm" class="mt-4"/>
            <x-input placeholder="Telefone" wire:model.live="phone" class="mt-4" x-mask:dynamic="$input.length === 14 ? '(99) 9999-9999' : '(99) 99999-9999' "/>
            <x-input placeholder="E-mail" wire:model.live="email" class="mt-4"/>
        </div>

        <x-slot:actions>
            <x-button label="Cancelar" icon="o-x-mark" wire:click="clear" spinner class="danger"/>
            <x-button label="{{$isEditMode ? 'Editar' : 'Criar'}}" icon="o-plus-circle" class="btn-primary" wire:click="{{$isEditMode ? 'update' : 'store'}}"/>
        </x-slot:actions>
    </x-drawer>

    <x-card>
        <x-table :headers="$headerTable" :rows="$doctors" with-pagination striped>
            @scope('actions', $doctor)
            <div class="flex">
                <x-button icon="o-pencil-square" wire:click="edit({{ $doctor->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                <x-button icon="o-trash" wire:click="delete({{ $doctor->id }})" spinner class="btn-ghost btn-sm text-red-500"/>
            </div>
            @endscope
        </x-table>
    </x-card>

</div>
