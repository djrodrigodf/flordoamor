<div>
    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-1 2xl:grid-cols-2 gap-4">
        <x-card title="Dados Pessoais" shadow separator>

            <x-avatar-upload image="https://picsum.photos/200?x=248375598" photo="{{$foto ? $foto->media[0]->original_url : asset('user.png')}}" modelUpload="photoPerfil" class="!w-24">

                <x-slot:title class="text-2xl pl-2">
                    {{$patient->name}} <br> {{$patient->cpf}}
                </x-slot:title>

                <x-slot:subtitle class="text-gray-500 flex flex-col gap-1 mt-2 pl-2">
                    <p><b>E-mail: </b>{{$patient->email}}</p>
                    <p><b>Telefone: </b>{{$patient->phone}}</p>
                    @if($patient->birth_date)<p><b>Aniversario: </b>{{\Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y')}}</p>@endif
                    @if($patient->rg) <p><b>RG: </b>{{$patient->rg}} @if($patient->ssp) - {{$patient->ssp}} @endif</p> @endif
                    <p><b>Cep: </b>{{$patient->postal_code}}</p>
                    <p><b>Endereço: </b>{{$patient->address}} {{$patient->number}} {{$patient->complement}}</p>
                    <p><b>Cidade: </b>{{$patient->city}} - {{$patient->state}}</p>
                    <p><b>Bairro: </b>{{$patient->neighborhood}}</p>
                    @if($patient->complement) <p><b>OBS: </b>{!! $patient->complement !!}</p> @endif

                </x-slot:subtitle>

            </x-avatar-upload>
        </x-card>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
            <x-card title="Plano de Saúde" shadow separator>
                <div class="flex justify-end">
                    <x-button label="Cadastrar" class="btn-success btn-sm text-xs"></x-button>
                </div>
                <p><b>Nome:</b> UNIMED</p>
                <p><b>Apólice:</b> 123</p>
                <p><b>Validade:</b> 12/12/2025</p>
            </x-card>
            <x-card title="Contato de Emergencia" shadow separator>
                <div class="flex justify-end">
                    <x-button label="{{$contact ? 'Editar' : 'Cadastrar'}}" wire:click="$toggle('showDrawerContact')" class="btn-success btn-sm text-xs"></x-button>
                </div>
                @if($contact)
                <p><b>Nome:</b> {{$contact['name']}}</p>
                <p><b>Relação com Paciente:</b> {{$contact['relationship']}}</p>
                <p><b>Telefone:</b> {{$contact['phone']}}</p>
                @endif
            </x-card>
        </div>

    </div>

    <div class="grid grid-cols-1 gap-4 mt-4">
        <x-card title="Histórico / Observações">
            <div class="flex justify-end">
                <x-button label="Novo" wire:click="$toggle('showDrawerHistory')" class="btn-success btn-sm text-xs"></x-button>
            </div>

            <x-drawer wire:model="showDrawerHistory" class="w-11/12 lg:w-1/3" right>
                <x-form>
                    <x-input label="Titulo" wire:model="newHistory.title" />
                    <x-textarea
                        wire:model="newHistory.description"
                        placeholder="Descrição"
                        hint="Max 1000 chars"
                        rows="5"
                        inline />
                </x-form>
                <div class="flex gap-4 mt-4">
                    <x-button label="Close" @click="$wire.showDrawerHistory = false" />
                    <x-button label="Enviar" class="btn-primary" wire:click="sendHistory" />
                </div>
            </x-drawer>

            <div class="scrollable-div mt-4">
                @foreach($historys as $h)

                    <x-timeline-item-custom title="{{$h->title}}"
                                            idData="{{$h->user_id}}"
                                            btn="editHistory({{$h->id}})"
                                     subtitle="{{$h->user->name}} {{\Carbon\Carbon::parse($h->created_at)->format('d/m/Y H:i:s')}}"
                                     description="{{$h->description}}"/>
                @endforeach

            </div>


        </x-card>
        <x-card>
            <x-tabs
                wire:model="selectedTab"
                active-class="bg-primary rounded text-white"
                label-class="font-semibold"
                label-div-class="bg-primary/5 p-2 rounded"
            >
                <x-tab name="users-tab" label="Consultas/Atendimento">
                    <div>Consultas/Atendimento</div>
                </x-tab>
                <x-tab name="documents-tab" label="Documentos">
                    <div class="flex justify-end">
                        <x-button label="Novo" @click="$wire.myModal1 = true" class="btn-success btn-sm text-xs"></x-button>
                    </div>

                    <x-modal wire:model="myModal1" class="backdrop-blur">
                        <div class="mb-5">
                            <x-select class="mb-5" label="Tipo de documento" placeholder="Selecione" :options="$fileType" wire:model="newDocument.document_type" />
                            <x-file class="mb-5 w-full" wire:model="newDocument.file" label="Arquivo" />
                            <x-textarea
                                placeholder="Descrição do documento"
                                wire:model="newDocument.description"
                                hint="Max 500 chars"
                                rows="5"
                                inline />
                        </div>
                        <x-button label="Cancel" @click="$wire.myModal1 = false" />
                        <x-button label="Enviar" class="btn-primary" wire:click="sendFile" />
                    </x-modal>

                    <x-card title="Documentos">
                        <x-table :headers="$headerTable" :rows="$documents" striped>
                            @scope('cell_files', $document)
                            <a class="btn btn-sm btn-warning" href="{{ $document['media'][0]['original_url'] }}" target="_blank">{{ trans('global.downloadFile') }}</a>
                            @endscope
                            @scope('cell_created_at', $document)
                            {{\Carbon\Carbon::parse($document['created_at'])->format('d/m/Y H:i:s')}}
                            @endscope
                        </x-table>
                    </x-card>
                </x-tab>
                <x-tab name="musics-tab" label="Tratamentos">
                    <div>Tratamentos</div>
                </x-tab>


            </x-tabs>

        </x-card>


        <x-drawer wire:model="showDrawerContact" class="w-11/12 lg:w-1/3">
            <x-form>
                <x-input label="Nome" wire:model="contact.name" />
                <x-input label="Relação com Paciente" wire:model="contact.relationship" />
                <x-input label="Telefone" wire:model="contact.phone" x-mask:dynamic="$input.length === 14 ? '(99) 9999-9999' : '(99) 99999-9999' " />
            </x-form>
            <x-button class="mt-4 btn" label="Cancelar" @click="$wire.showDrawerContact = false" />
            <x-button class="mt-4 btn btn-primary" label="Salvar" wire:click="saveContact" />
        </x-drawer>

    </div>

</div>
