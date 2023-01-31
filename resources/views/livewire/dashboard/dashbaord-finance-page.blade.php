<div>
    <x-loading-indicator />
    <div class="card">
        <div class="card-header bg-success text-uppercase">
            <div>
                @if ($isFilterdByDay==true)
                    <h3>&#x1F4B0; Evolution des recetees par jour</h3>
                @else
                    <h3>&#x1F4B0; Evolution des recetees par mois</h3>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div></div>
                <div class="d-flex justify-content-start align-items-center">
                    <div class="form-group mr-4">
                        <x-label value="{{ __('Filtrer par date') }}" />
                        <x-input class="" type='date'
                                placeholder="Lieu de naissance" wire:model='date_to_search'/>
                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group pr-4">
                        <x-label value="{{ __('Filtrer par mois') }}" />
                        <x-select wire:model='month'>
                            @foreach ($months as $m)
                            <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                            @endforeach
                        </x-select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div id="chart-dash-fin"></div>
                </div>
                <div class="col-md-6">
                    <div class="row mt-4">
                        <div class="col-md-6">
                                <!-- small box -->
                            <div class="small-box bg-info
                                        ">
                                <div class="inner">
                                    <h3>{{number_format($recette,1,',',' ') }} FC</h3>
                                    <h4>Entrées</h4>
                                </div>
                            <a  class="small-box-footer"> <span class="p-2"></span></a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- small box -->
                            <div class="small-box bg-secondary
                                    ">
                            <div class="inner">
                                <h3>{{number_format($depense,1,',',' ')}} Fc</h3>
                                <h4>Dépenses</h4>
                            </div>
                            <a  class="small-box-footer"> <span class="p-2"></span></a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- small box -->
                    <div class="small-box bg-danger text-center
                                ">
                        <div class="inner">
                            <h3>{{number_format($this->recette-$depense,1,',',' ')}} Fc</h3>
                            <h2>SOLDE</h2>
                        </div>
                    <a  class="small-box-footer"> <span class="p-2"></span></a>
                    </div>
                </div>

            </div>
        </div>
     </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-2">
                    <div class="card-header bg-info">
                       <H3> SITUATION PAIEMENT FRAIS</H3>
                    </div>
                    <div class="card-body">
                        <div id="chart-paie"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-2">
                    <div class="card-header bg-primary">
                       <H3> SITUATION PAIEMENT INSCRIPTIONS</H3>
                    </div>
                    <div class="card-body">
                        <div id="chart-insc-amount"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 </div>

 <script setup>
    var options = {
         legend: {
           horizontalAlign: 'left'
         },
         dataLabels: {
                 enabled: false,
             },
         chart: {
             type: 'pie',
             height:500,
             expandOnClick: true,
             customScale: 0.8,
             size: 50,
             zoom: {
                 enabled: true
             },
             animations:{
                 enabled:true
             }
         },
         series: @json($dataRecetteY),
         labels: @json($dataRecetteLabel),
         chartOptions: {
             labels: @json($dataRecetteLabel)
         }
    }
    var options2 = {
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: true
            },
            animations:{
                enabled:true
            }
        },

        legend: {
          horizontalAlign: 'left'
        },
        series: [
            {
                name: 'Montant',
                data: @json($amountDataX)
            },
        ],
        xaxis: {
            categories: @json($valuesMonthY)
        }

    }
    var options3 = {
        chart: {
            type: 'area',
            height: 350,
            zoom: {
                enabled: true
            },
            animations:{
                enabled:true
            }
        },

        legend: {
          horizontalAlign: 'left'
        },
        series: [
            {
                name: 'Montant',
                data: @json($amountDataInscX)
            },
        ],
        xaxis: {
            categories: @json($monthsPaieDataY)
        }

    }
     var chart = new ApexCharts(document.querySelector("#chart-dash-fin"), options);
     var chart2 = new ApexCharts(document.querySelector("#chart-paie"), options2);
     var chart3 = new ApexCharts(document.querySelector("#chart-insc-amount"), options3);
     chart.render();
     chart2.render();
     chart3.render();


 </script>
