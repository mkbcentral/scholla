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
                    <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                @endforeach
            </x-select>
        </div>
        <div class="form-group pr-4">
           <a target="_blank" href="{{ route('recettes.print',$month) }}">Imprimer rapport</a>
        </div>
    </div>
    <div class="row mt-4">
        @foreach ($costs as $cost)
            <div class="col-md-3">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner  text-center">
                        <h3>{{number_format($cost->getTotal($month,$cost->id)*2000,1,',',' ')}}  FC</h3>
                        <h4>{{$cost->name}}</h4>
                    </div>
                    <a  class="small-box-footer"> <span class="p-2"></span></a>
                </div>
                @php
                    $total+=$cost->getTotal($month,$cost->id)*2000;
                    if ($cost->id==6) {
                        $total_etat+=$cost->getTotal($month,$cost->id)*2000;
                    }
                @endphp
            </div>
        @endforeach
        <div class="col-md-3">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner  text-center">
                    <h3>{{number_format($inscription*2000,1,',',' ')}}  FC</h3>
                    <h4>INSCRIPTION</h4>
                </div>
                <a  class="small-box-footer"> <span class="p-2"></span></a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-md-12">
                    <h2 class="text-bold text-primary">Total: CDF {{number_format($total+$inscription*2000,1,',',' ')}}</h2>
                    <h2 class="text-bold text-danger">Compte Etat: CDF {{number_format($total_etat,1,',',' ') }}</h2>
                    <h2 class="text-bold text-info">Reste pour école: CDF {{number_format($total+$inscription*2000-$total_etat,1,',',' ')}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
