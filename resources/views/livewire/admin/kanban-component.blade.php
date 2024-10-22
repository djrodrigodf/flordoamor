
<div>
    <x-header title="Esteira de Pedidos" separator progress-indicator />

    <div class="flex justify-between gap-6 p-4 overflow-x-auto" x-data="kanbanDragAndDrop()">

        <!-- Coluna: Aguardando Pagamento -->
        <div class="bg-primary-content shadow-md p-4 rounded-lg"
             x-on:drop="drop('Aguardando Pagamento')"
             x-on:dragover.prevent>



            <h2 class="text-lg font-bold mb-4 text-center min-w-[300px]">AGUARDANDO PAGAMENTO</h2>
            <div class="space-y-4">
                @foreach($orders as $order)
                    @if($order['status'] === 'Aguardando Pagamento')
                        <div class="bg-base-100 p-4 rounded-lg shadow-md border  cursor-pointer indicator max-w-7xl w-full"
                             draggable="true"
                             x-on:dragstart="startDragging({{ $order['id'] }})"
                             x-on:dragend="endDragging()"
                             x-on:mousedown="mouseDown()"
                             x-on:mouseup="mouseUp({{ $order['id'] }})"
                             wire:key="order-{{ $order['id'] }}"
                        >
                            <div class="w-full">
                                <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                                <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                                <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                                <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                                <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                            </div>

                                <span class="indicator-item border-0 indicator-center badge badge-base-100">Data Pedido: {{\Carbon\Carbon::parse($order->created_at)->format('d/m/Y')}}</span>


                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Coluna: Entrada de Pedido -->
        <div class="bg-primary-content shadow-md p-4 rounded-lg min-w-[300px]"
             x-on:drop="drop('Entrada de Pedido')"
             x-on:dragover.prevent
        >
            <h2 class="text-lg font-bold mb-4 text-center min-w-[300px]">ENTRADA DE PEDIDO</h2>
            <div class="space-y-4">
                @foreach($orders as $order)
                    @if($order['status'] === 'Entrada de Pedido')
                        <div class="bg-base-100 p-4 rounded-lg shadow-md border cursor-pointer"
                             draggable="true"
                             x-on:dragstart="startDragging({{ $order['id'] }})"
                             x-on:dragend="endDragging()"
                             x-on:mousedown="mouseDown()"
                             x-on:mouseup="mouseUp({{ $order['id'] }})"
                             wire:key="order-{{ $order['id'] }}"
                        >
                            <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                            <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                            <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                            <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                            <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Coluna: Pedido em Preparação -->
        <div class="bg-primary-content shadow-md p-4 rounded-lg min-w-[300px]"
             x-on:drop="drop('Pedido em Preparacao')"
             x-on:dragover.prevent>
            <h2 class="text-lg font-bold mb-4 text-center min-w-[300px]">PEDIDO EM PREPARAÇÃO</h2>
            <div class="space-y-4">
                @foreach($orders as $order)
                    @if($order['status'] === 'Pedido em Preparacao')
                        <div class="bg-base-100 p-4 rounded-lg shadow-md border cursor-pointer"
                             draggable="true"
                             x-on:dragstart="startDragging({{ $order['id'] }})"
                             x-on:dragend="endDragging()"
                             x-on:mousedown="mouseDown()"
                             x-on:mouseup="mouseUp({{ $order['id'] }})"
                             wire:key="order-{{ $order['id'] }}">
                            <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                            <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                            <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                            <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                            <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                        </div>
                    @endif
                @endforeach
            </div>

            <x-drawer wire:model="pedidoPreparacaoDrawer" title="Atualização de Status" class="w-11/12 lg:w-1/3">
                <div>Deseja mover o pedido para <b>{{$titleDrawer}}</b>?</div>
                <x-card shadow class="bg-base-300 mt-4">
                    <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                    <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                    <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                    <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                    <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                </x-card>
                <x-form class="mt-4">
                    @if($titleDrawer == 'pronto para Entrega')
                        <x-input placeholder="Codigo de envio" wire:model="tracking_number" />
                    @endif
                </x-form>

                <div class="mt-4">
                    <x-button label="Cancelar" class="btn-outline" @click="$wire.pedidoPreparacaoDrawer = false" />
                    @if($titleDrawer == 'Aguardando Pagamento')
                        <x-button label="Revogar Pagamento" class="btn-success" wire:click="revogarPagamento" />
                    @endif

                    @if($titleDrawer == 'pronto para Entrega')
                        <x-button label="Cadastrar envio" class="btn-success" wire:click="sendShip" />
                    @endif

                    @if($titleDrawer == 'Entrada de Pedido')
                        <x-button label="Confirmar Pagamento" class="btn-success" wire:click="confirmarPagamento" />
                    @endif
                </div>
            </x-drawer>

            @if($selectKanban)
                <x-modal title="{{$selectKanban->status}}" box-class="w-11/12 max-w-5xl" wire:model="detailModal" class="backdrop-blur">
                    <x-card class="bg-base-300" title="{{$selectKanban->patient->name}}">
                        <x-slot:menu>
                            <span class="badge badge-primary">Pedido: {{$selectKanban->id}}</span>
                        </x-slot:menu>
                        <div class="grid grid-cols-2 gap-1">

                            <p><b>CPF: </b>{{$selectKanban->patient->cpf}}</p>
                            <p><b>E-mail: </b>{{$selectKanban->patient->email}}</p>
                            <p><b>Telefone: </b>{{$selectKanban->patient->phone}}</p>
                            @if($selectKanban->patient->rg) <p><b>RG: </b>{{$selectKanban->patient->rg}} @if($selectKanban->patient->ssp) - {{$selectKanban->patient->ssp}} @endif</p> @endif
                            <p><b>Cep: </b>{{$selectKanban->patient->postal_code}}</p>
                            <p><b>Endereço: </b>{{$selectKanban->patient->address}} {{$selectKanban->patient->number}} {{$selectKanban->patient->complement}}</p>
                            <p><b>Cidade: </b>{{$selectKanban->patient->city}} - {{$selectKanban->patient->state}}</p>
                            <p><b>Bairro: </b>{{$selectKanban->patient->neighborhood}}</p>


                            @if($selectKanban['shipping'] && $selectKanban['shipping']['tracking_number'])
                                <p class="text-sm"><b>Rastreio: </b>{{ $selectKanban['shipping']['tracking_number'] }}</p>
                            @endif



                        </div>
                    </x-card>
                    <hr class="mt-4">
                    <div class="flex gap-4">
                        @if($selectKanban['shipping'])
                            <x-stat
                                title="Frete"
                                value="{{ $selectKanban['shipping']['shipping_cost'] ? 'R$ ' . number_format($selectKanban['shipping']['shipping_cost'], 2, ',', '.') : 'R$ 0,00' }}"
                                icon="fas.shipping.fast"
                            />
                        @endif

                       @if($selectKanban['items'])
                                <x-stat
                                    title="Total Itens"
                                    value="{{ $selectKanban['items'] ? 'R$ ' . number_format($selectKanban['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}"
                                    icon="fas.shopping.cart"
                                    description="Quantidade {{ count($selectKanban['items']) }}"
                                />
                       @endif

                        @if($selectKanban['items'] && $selectKanban['shipping'])
                                <x-stat
                                    title="Valor Total"
                                    value="{{ $selectKanban['items'] ? 'R$ ' . number_format($selectKanban['items']->sum('price') + $selectKanban['shipping']['shipping_cost'], 2, ',', '.') : 'R$ 0,00' }}"
                                    icon="fas.file.invoice.dollar"
                                />
                        @endif


                    </div>



                    <x-card>
                        <x-table :headers="$headerTable" :rows="$selectKanban->items" striped>
                            @scope('cell_created_at', $invoice)
                            {{\Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y H:i')}}
                            @endscope
                        </x-table>
                    </x-card>
                    <hr class="mt-4">
                    <x-card  class="bg-base-300 mt-4" title="Histórico">
                        @foreach($historic as $h)

                            <x-timeline-item
                                title="{{$h['status'] ? strtoupper($h['status']) : ''}}"
                                subtitle="{{$h['created_at'] ? \Carbon\Carbon::parse($h['created_at'])->format('d/m/Y H:i:s') : ''}}"
                                description="{{$h['user']}}"
                            />
                        @endforeach
                    </x-card>
                    <div class="mt-4">
                        <x-button label="Cancel" @click="$wire.detailModal = false" />
                    </div>

                </x-modal>
            @endif


        </div>

        <!-- Coluna: Pedido Pronto para Entrega -->
        <div class="bg-primary-content shadow-md p-4 rounded-lg min-w-[300px]"
             x-on:drop="drop('Pedido pronto para Entrega')"
             x-on:dragover.prevent>
            <h2 class="text-lg font-bold mb-4 text-center">PEDIDO PRONTO PARA ENTREGA</h2>
            <div class="space-y-4">
                @foreach($orders as $order)
                    @if($order['status'] === 'Pedido pronto para Entrega')
                        <div class="bg-base-100 p-4 rounded-lg shadow-md border cursor-pointer"
                             draggable="true"
                             x-on:dragstart="startDragging({{ $order['id'] }})"
                             x-on:dragend="endDragging()"
                             x-on:mousedown="mouseDown()"
                             x-on:mouseup="mouseUp({{ $order['id'] }})"
                             wire:key="order-{{ $order['id'] }}">
                            <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                            <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                            <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                            <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                            <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                            <p class="text-sm">Rastreio: {{ $order['shipping']['tracking_number'] }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Coluna: Pedido Entregue -->
        <div class="bg-primary-content shadow-md p-4 rounded-lg min-w-[300px]"
             x-on:drop="drop('Pedido Entregue')"
             x-on:dragover.prevent>
            <h2 class="text-lg font-bold mb-4 text-center">PEDIDO ENTREGUE</h2>
            <div class="space-y-4">
                @foreach($orders as $order)
                    @if($order['status'] === 'Pedido Entregue')
                        <div class="bg-base-100 p-4 rounded-lg shadow-md border cursor-pointer"
                             draggable="true"
                             x-on:dragstart="startDragging({{ $order['id'] }})"
                             x-on:dragend="endDragging()"
                             x-on:mousedown="mouseDown()"
                             x-on:mouseup="mouseUp({{ $order['id'] }})"
                             wire:key="order-{{ $order['id'] }}">
                            <p class="text-sm"><b>{{ $order['patient']['name'] }}</b></p>
                            <p class="text-sm">Telefone: {{ $order['patient']['phone'] }}</p>
                            <p class="text-sm">CPF: {{ $order['patient']['cpf'] }}</p>
                            <p class="text-sm">Qtd Itens: {{ count($order['items']) }}</p>
                            <p class="text-sm">Valor Total: {{ $order['items'] ? 'R$ ' . number_format($order['items']->sum('price'), 2, ',', '.') : 'R$ 0,00' }}</p>
                            <p class="text-sm">Rastreio: {{ $order['shipping']['tracking_number'] }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

</div>



<script>
    function kanbanDragAndDrop() {
        return {
            draggingOrderId: null,
            clickStartTime: null,

            mouseDown() {
                this.clickStartTime = Date.now(); // Armazena o tempo em que o clique começou
            },

            mouseUp(orderId) {
                const clickDuration = Date.now() - this.clickStartTime;

                // Se o tempo de clique for menor que 200ms, consideramos que foi um click rápido
                if (clickDuration < 200) {
                @this.call('openModal', orderId);
                }
            },

            startDragging(orderId) {
                this.draggingOrderId = orderId;
            },

            endDragging() {
                this.draggingOrderId = null;
            },

            drop(newStatus) {
                if (this.draggingOrderId) {
                    // Atualiza o status do pedido via Livewire
                @this.call('updateOrderStatus', this.draggingOrderId, newStatus);
                }
            }
        }
    }
</script>
