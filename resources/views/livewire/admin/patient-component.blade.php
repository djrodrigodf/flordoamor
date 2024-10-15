<div>
    <x-header title="Pacientes" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input placeholder="Pesquisar..." wire:model.live.debounce="search" clearable icon="o-magnifying-glass"/>
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo" wire:click="edit()" responsive icon="o-funnel" class="btn-primary"/>
        </x-slot:actions>
    </x-header>
@if($drawerForm)
    <x-drawer wire:model="drawerForm" title="{{$isEditMode ? 'Editar Paciente' : 'Adicionar Paciente'}}" right separator with-close-button class="lg:w-1/3">



        <div>
            <x-input placeholder="Nome" wire:model.live="name"/>
            <x-input placeholder="E-mail" wire:model.live="email" class="mt-4"/>
            <x-input placeholder="Telefone" wire:model.live="phone" class="mt-4" x-mask:dynamic="$input.length === 14 ? '(99) 9999-9999' : '(99) 99999-9999' "/>
            @if($isEditMode)
                <x-input placeholder="CPF" readonly  wire:model.blur="cpf" class="mt-4" x-mask="999.999.999-99"/>
            @else
                <x-input placeholder="CPF"  wire:model.blur="cpf" class="mt-4" x-mask="999.999.999-99"/>
            @endif

            <x-datetime label="Data de Nascimento" inline  placeholder="Data de Nascimento" wire:model.live="birth_date" class="mt-4"/>
            <x-input placeholder="RG" wire:model.live="rg" class="mt-4"/>
            <x-input placeholder="Orgão Emissor" wire:model.live="ssp" class="mt-4"/>
            <x-input placeholder="CEP" wire:model.blur="postal_code" class="mt-4" x-mask="99999-999"/>
            <x-input placeholder="Endereço" wire:model.live="address" class="mt-4"/>
            <x-input placeholder="Número" wire:model.live="number" class="mt-4"/>
            <x-input placeholder="Complemento" wire:model.live="complement" class="mt-4"/>

            <x-input-custom placeholder="Bairro" :onlyread="$blockBairro" wire:model.live="neighborhood" class="mt-4" />
            <x-input placeholder="Cidade" readonly wire:model.live="city" class="mt-4"/>
            <x-input placeholder="Estado" readonly wire:model.live="state" class="mt-4"/>

            <x-quill-edit
                content="{!! $observations !!}"
                theme="snow"
                wireModel="observations"
            />


        </div>

        <x-slot:actions>
            <x-button label="Cancelar" icon="o-x-mark" wire:click="clear" spinner class="danger"/>
            <x-button label="{{$isEditMode ? 'Editar' : 'Criar'}}" icon="o-plus-circle" class="btn-primary" wire:click="{{$isEditMode ? 'update' : 'store'}}"/>
        </x-slot:actions>
    </x-drawer>
    @endif
    <x-card>
        <x-table :headers="$headerTable" :rows="$patients" with-pagination striped>
            @scope('actions', $patient)
            <div class="flex">
                <x-button icon="fas.eye" wire:click="detail({{ $patient->id }})" spinner class="btn-ghost btn-sm text-blue-500"/>
                <x-button icon="o-pencil-square" wire:click="edit({{ $patient->id }})" spinner class="btn-ghost btn-sm text-green-500"/>
                <x-button icon="o-trash" wire:click="delete({{ $patient->id }})" spinner class="btn-ghost btn-sm text-red-500"/>
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
