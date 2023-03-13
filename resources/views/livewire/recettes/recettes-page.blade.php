<div>
    <div>
        <x-loading-indicator />
        @php
            $total=0;
            $total_etat=0;
        @endphp
        <div class="card">
            <div class="card-body">
                <h3 class="text-bold text-primary text-uppercase text-center">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Recettes mensuelles</h3>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-between">
            <div class="form-group pr-4">
                <x-label value="{{ __('Filtrer par mois') }}" />
                <x-select wire:model='month'>
                    @foreach ($months as $m)
                    <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                    @endforeach
                </x-select>
            </div>
            <div>
                <div class="form-group">
                    <label for="my-select">Anné scolaire</label>
                      <div class="input-group date"  >
                        <select id="my-select" class="form-control" wire:model.defer='scolary_id'>
                            <option >Choisir...</option>
                            @foreach ($scolaryyears as $year)
                                <option wire:click.prevent='changeScolaryid' value="{{$year->id}}">{{$year->name}}</option>
                            @endforeach
                        </select>
                          <div class="input-group-append" >
                                <button wire:click='changeScolaryid' class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                          </div>
                      </div>
                  </div>
            </div>
        </div>
        <div class="d-flex justify-content-end  mt-4">
            <div class="form-group pr-4">
                <a target="_blank" href="{{ route('recettes.print',[$month,$defaultScolaryYer->id]) }}"><i class="fa fa-print" aria-hidden="true"></i> Imprimer rapport</a>
             </div>
        </div>
        <div class="row">
            @foreach ($costs as $cost)
                @if ($cost->getTotal($month,$cost->id,$defaultScolaryYer->id) >0)
                <div class="col-md-3">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner  text-center">
                            <h4 class="text-bold">{{number_format($cost->getTotal($month,$cost->id,$defaultScolaryYer->id),1,',',' ')}}  FC</h4>
                            <h5>{{$cost->name}}</h5>
                        </div>
                        <a  class="small-box-footer"> <span class="p-2"></span></a>
                    </div>
                    @php
                        $total+=$cost->getTotal($month,$cost->id,$defaultScolaryYer->id);
                        if ($cost->id==6) {
                            $total_etat+=$cost->getTotal($month,$cost->id,$defaultScolaryYer->id);
                        }
                    @endphp
                </div>
                @endif

            @endforeach
            @if ($inscription>0)
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box bg-warning">
                    <div class="inner  text-center">
                        <h4>{{number_format($inscription*2000,1,',',' ')}}  FC</h4>
                        <h5>INSCRIPTION</h5>
                    </div>
                    <a  class="small-box-footer"> <span class="p-2"></span></a>
                </div>
            </div>
            @endif
        </div>
        @php
            $amount_depense=0;
            foreach ($depenses as $depense) {
                $amount_depense+=$depense->amount;
            }
        @endphp
        @if (Auth::user()->roles->pluck('name')->contains('Finance'))
        <div class="d-flex justify-content-end">
            <button class="btn btn-danger mr-2" type="button" data-toggle="modal" data-target="#addDepenseRecetteModal">Depenses</button>
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addSalaireModal">Fixer salair</button>
        </div>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="text-bold text-primary">Total: CDF {{number_format($total+$inscription*2000,1,',',' ')}}</h5>
                            <hr>
                            <h5 class="text-bold text-danger">Compte Etat: CDF {{number_format($total_etat,1,',',' ') }}</h5>
                            <hr>
                            <h5 class="text-bold text-success">Sit. pâie: CDF {{number_format($paie,1,',',' ') }}</h5>
                            <hr>
                            <a href=""><h5 class="text-bold text-secondary">Dépenses: CDF {{number_format($amount_depense,1,',',' ') }}</h5></a>
                            <hr>
                            <h5 class="text-bold text-info">Reste pour école: CDF {{number_format((($total+$inscription*2000-$total_etat)-$paie)-$amount_depense,1,',',' ')}}</h5>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="card">
                <div class="card-body">
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5 class="text-bold text-primary">Total: CDF {{number_format($total+$inscription*2000,1,',',' ')}}</h3>
                            <hr>
                            <h3 class="text-bold text-danger">Compte Etat: CDF {{number_format($total_etat,1,',',' ') }}</h3>
                            <hr>
                            <h3 class="text-bold text-info">Reste pour école: CDF {{number_format($total+$inscription*2000-$total_etat,1,',',' ')}}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    @include('livewire.recettes.modals.add-salaire')
    @include('livewire.recettes.modals.add-depense-recette')
</div>

