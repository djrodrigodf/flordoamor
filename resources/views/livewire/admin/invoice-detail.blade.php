<div>

    <x-header title="Pedido {{$id}}" separator progress-indicator />

    @if(!$invoice->payment_method)
        <div class="flex justify-end mb-4">
            <x-button label="Gerar Pedido" responsive icon="fas.file.invoice.dollar" wire:click="generateInvoice" class="btn-primary"/>
        </div>

        <x-drawer wire:model="paymentDrawer" title="Pagamento" class="w-11/12 lg:w-1/3" right>
            <x-form>
                <x-input placeholder="Forma de Pagamento" wire:model="paymentMethod"></x-input>
                <div>
                    <x-button label="Cancelar" @click="$wire.paymentDrawer = false" />
                    <x-button label="Salvar" class="btn-primary" wire:click="saveInvoice" />
                </div>
            </x-form>

        </x-drawer>

    @endif

    <div class="mb-4">
        <x-card title="{{$patient->name}}" separator>

            <div class="grid grid-cols-3 gap-4">
                <p><b>CPF: </b>{{$patient->cpf}}</p>
                <p><b>E-mail: </b>{{$patient->email}}</p>
                <p><b>Telefone: </b>{{$patient->phone}}</p>
                @if($patient->birth_date)<p><b>Aniversario: </b>{{\Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y')}}</p>@endif
                @if($patient->rg) <p><b>RG: </b>{{$patient->rg}} @if($patient->ssp) - {{$patient->ssp}} @endif</p> @endif
                <p><b>Cep: </b>{{$patient->postal_code}}</p>
                <p><b>Endereço: </b>{{$patient->address}} {{$patient->number}} {{$patient->complement}}</p>
                <p><b>Cidade: </b>{{$patient->city}} - {{$patient->state}}</p>
                <p><b>Bairro: </b>{{$patient->neighborhood}}</p>
                @if($patient->complement) <p><b>OBS: </b>{!! $patient->complement !!}</p> @endif
            </div>
        </x-card>
    </div>
    <div class="grid grid-cols-2 gap-4">
        <x-card title="Pagamento" separator>
            <div class="flex justify-between items-center py-2">
                    <span>Tipo Pagamento</span>
                <span class="flex-grow border-b border-dotted border-gray-600 mx-2"></span>
                <span class="font-bold">{{$invoice->payment_method}}</span>
            </div>

            <div class="flex justify-between items-center py-2">
                <span>Status Pagamento</span>
                <span class="flex-grow border-b border-dotted border-gray-600 mx-2"></span>
                <span class="font-bold">{{$invoice->payment_status}}</span>
            </div>
        </x-card>
            <x-card title="Resumo" separator>
                @if(!empty($shipping) && !$invoice->payment_method)
                    <x-slot:menu>
                        <x-button label="Editar Frete" wire:click="EditShipp" class="btn-success btn-sm" />
                    </x-slot:menu>
                @endif

                <div class="w-full p-4 rounded-lg">


                    <div class="flex justify-between items-center py-2">
                        <span class="font-bold">Frete</span>
                        <span class="flex-grow border-b border-dotted border-gray-600 mx-2"></span>
                        @if(empty($shipping))
                            <x-button label="Adicionar Frete" class="btn-sm btn-success" wire:click="$toggle('shippingDrawer')"></x-button>
                        @else
                            <span class="font-bold">R$ {{number_format($shipping->shipping_cost, 2, ',', '.')}}</span>
                        @endif
                    </div>

                    <x-drawer wire:model="shippingDrawer" title="Frete" class="w-11/12 lg:w-1/3" right>
                        <x-form>
                            <x-input placeholder="Transportadora" wire:model="shipp.carrier"></x-input>
                            <x-input placeholder="Valor" wire:model.live="shipp.shipping_cost" x-mask:dynamic="$money($input, ',')" class="mt-4" />
                            <div>
                                <x-button label="Cancelar" @click="$wire.shippingDrawer = false" />
                                <x-button label="Cadastrar" class="btn-primary" wire:click="saveShipp" />
                            </div>
                        </x-form>

                    </x-drawer>
                    @php

                        if (empty($itensInvoice)) {
                            $total = 0;
                            if (!empty($shipping)) {
                                $total = 0 + $shipping->shipping_cost;
                            }
                        } else {
                            $itens = array_sum(array_column($itensInvoice->toArray(), 'price'));
                            $total = $itens;
                            if (!empty($shipping)) {
                                $total += $shipping->shipping_cost;
                            }
                        }
                    @endphp

                    <div class="flex justify-between items-center py-2">
                    <span class="font-bold">Items
                    <x-badge value="{{count($itensInvoice)}}" class="badge-neutral" /></span>
                        <span class="flex-grow border-b border-dotted border-gray-600 mx-2"></span>
                        <span class="font-bold">R$ {{number_format($itens, 2, ',', '.')}}</span>
                    </div>
                    <!-- Total Row -->
                    <div class="flex justify-between items-center py-2">
                        <span class="font-bold">Total</span>
                        <span class="flex-grow border-b border-dotted border-gray-600 mx-2"></span>
                        <span class="font-bold">R$ {{number_format($total, 2, ',', '.')}}</span>
                    </div>
                </div>
            </x-card>



    </div>

    <div class="mt-4">
        <x-card title="Items" separator>
            @if(!$invoice->payment_method)
            <x-slot:menu>
                <x-button icon="o-plus" wire:click="$toggle('newProduct')" class="btn-circle btn-primary btn-sm" />
            </x-slot:menu>
            @endif
            <x-table :headers="$headerTable" :rows="$itensInvoice" striped>
                @scope('cell_created_at', $invoice)
                {{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i')}}
                @endscope

                @if(!$invoice->payment_method)
                    @scope('actions', $invoiceItem)
                <div class="flex space-x-2">
                    <!-- Botão para excluir a fatura -->
                    <x-button
                        icon="o-trash"
                        wire:click="deleteItem({{ $invoiceItem->id }})"
                        spinner
                        class="btn-ghost btn-sm text-red-500"
                    />
                </div>
                    @endscope
                @endif

            </x-table>

        </x-card>
    </div>

    <x-drawer wire:model="newProduct" class="w-11/12 lg:w-1/3" right>

        <x-form>
            <x-choices
                label="Produtos"
                wire:model.live="productSelected"
                :options="$products"
                searchable
                search-function="searchProducts"
                placeholder="Pesquisar Produto..."
                single >
                @scope('item', $prod)
                <x-list-item :item="$prod" sub-value="description">
                    <x-slot:actions>
                        <x-badge :value="$prod->size" />
                    </x-slot:actions>
                </x-list-item>
                @endscope
                @scope('selection', $prod)
                {{ $prod->name }} - {{$prod->description}} ({{ $prod->size }})
                @endscope
            </x-choices>
            <x-input placeholder="Quantidade" wire:model="newItem.quantity" type="number" />
            <div>
                <x-button label="Cancelar" @click="$wire.newProduct = false" />
                <x-button label="Adicionar" class="btn-primary" wire:click="addProduct" />
            </div>
        </x-form>


    </x-drawer>

</div>
