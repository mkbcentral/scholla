<div>
    <x-loading-indicator />
    <div>
        <div class="d-flex justify-content-between">
            <div>
                <x-button wire:click.prevent='changeEditableState' class="btn-info" type="button" data-toggle="modal" data-target="#formReqModal">
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    Créer un nouvelle requisition
                </x-button>
            </div>
            <div>
                <a  target="_blank"
                    class="btn btn-danger" href="{{ route('requisition.rapport.print'
                    ,[$valuSorte,$month,$date_to_search]) }}">
                    &#x1F5A8; Imprimer
                </a>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <div><h4 class="text-uppercase text-bold text-secondary mt-4">Liste des requisition</h4></div>
            <div>
                <div class="d-flex justify-content-end align-items-center mr-4 mt-4">
                    <div class="form-group pr-4">
                        <x-label value="{{ __('Filtrer par moi') }}" />
                        <x-select wire:model='month'>
                            @foreach ($months as $m)
                                <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div>
                        <div class="form-group">
                            <x-label value="{{ __('Filtrer par date') }}" />
                            <x-input class="" type='date'
                                     placeholder="Date" wire:model='date_to_search'/>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <table class="table table-stripped table-sm mt-4">

            <thead class="thead-light">
                <tr class="text-uppercase">
                    <th>N°</th>
                    <th>Code</th>
                    <th class="text-center">Emitteur</th>
                    <th class="text-center">NBRE</th>
                    <th class="text-right">Montant</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($requisitions as $index => $requisition)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$requisition->code}}</td>
                        <td class="text-center">{{$requisition->emetter->name}}</td>
                        <td class="text-center">{{$requisition->details->count()}}</td>
                        <td class="text-right">{{$requisition->getTotal($requisition->id)}}</td>
                        <td class="text-center ">
                            <x-button data-toggle="modal" data-target="#formShowDetailModal"
                                 type='button' wire:click.prevent='showDetails({{$requisition}})'
                                 class="text-secondary"><i class="fas fa-eye"></i></x-button>
                            <x-button wire:click.prevent='activeRequisition({{$requisition}})'
                                 class="{{$requisition->active==false?'text-secondary':'text-danger'}}">
                                <i class="fa {{$requisition->active==false?'fa-check':'fa-times'}}"
                                     aria-hidden="true"></i>
                            </x-button>
                            @if ($requisition->active==false)
                                <x-button data-toggle="modal" data-target="#formReqModal"
                                    type='button' wire:click.prevent='edit({{$requisition}})'
                                    class="text-primary"><i class="fas fa-edit"></i>
                                </x-button>
                                <x-button data-toggle="modal" data-target="#formAddDetailModal"
                                    type='button' wire:click.prevent='edit({{$requisition}})'
                                    class="text-info"><i class="fas fa-plus"></i>
                                </x-button>
                                <x-button wire:click.prevent='showDeleteDialog({{$requisition}})'
                                    class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                </x-button>
                            @endif
                            <a  target="_blank"
                                class="" href="{{ route('requisition.print',$requisition->id) }}">
                                &#x1F5A8;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('livewire.requisition.modals.form-requisition')
        @include('livewire.requisition.modals.form-add-depense')
        @include('livewire.requisition.modals.show-detail-reqs')
    </div>
</div>
