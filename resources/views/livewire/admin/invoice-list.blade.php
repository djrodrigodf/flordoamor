<div>
    <x-header title="Pedidos" separator progress-indicator>
        <x-slot:middle class="!justify-end">
            <x-input
                placeholder="Pesquisar Fatura por Cliente..."
                wire:model.live.debounce="search"
                clearable
                icon="o-magnifying-glass"
            />
        </x-slot:middle>
        <x-slot:actions>
            <x-button label="Novo Pedido" @click="$wire.ModalAddClient = true" responsive icon="o-plus-circle" class="btn-primary"/>
        </x-slot:actions>
    </x-header>

    <x-drawer wire:model="ModalAddClient" class="w-11/12 lg:w-1/3" right>
        <x-card title="Selecione o Paciente">
            <x-form>
                <x-choices
                    label="Pacientes"
                    wire:model="patientSelected"
                    :options="$patients"
                    option-label="name"
                    option-sub-label="cpf"
                    icon="o-users"
                    searchable
                    search-function="searchPatients"
                    placeholder="Pesquisar..."
                    single />
            </x-form>
        </x-card>
        <x-button label="Cancelar" @click="$wire.ModalAddClient = false" />
        <x-button label="Criar Pedido" class="btn-primary" wire:click="createInvoice" />
    </x-drawer>

    <x-card>
        <x-table :headers="$headerTable" :rows="$invoices" with-pagination striped>
            @scope('cell_created_at', $invoice)
            {{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i')}}
            @endscope
            @scope('cell_total', $invoice)
            @php

                $itens = $invoice->items->sum('price');

            @endphp
            R$ {{$itens ? number_format($itens, 2, ',', '.') : '0,00'}}
            @endscope

            @scope('actions', $invoice)
            <div class="flex space-x-2">
                <!-- Botão para ver detalhes da fatura -->
                <x-button
                    icon="fas.eye"
                    wire:click="detail({{ $invoice->id }})"
                    spinner
                    class="btn-ghost btn-sm text-blue-500"
                />

                <!-- Botão para excluir a fatura -->
                <x-button
                    icon="o-trash"
                    wire:click="delete({{ $invoice->id }})"
                    spinner
                    class="btn-ghost btn-sm text-red-500"
                />
            </div>
            @endscope
        </x-table>
    </x-card>
</div>
