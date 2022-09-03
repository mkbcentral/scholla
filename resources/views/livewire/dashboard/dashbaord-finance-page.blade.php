<div>

    <div class="card">
     <div class="card-body">
        <div class="d-flex justify-content-between align-items-center">
             <div>
                 @if ($isFilterdByDay==true)
                     <h4>&#x1F4B0; Evolution des recetees par jour</h4>
                 @else
                     <h4>&#x1F4B0; Evolution des recetees par mois</h4>
                 @endif
             </div>
             <div class="d-flex justify-content-start align-items-center">
                 <div class="form-group mr-4">
                     <x-label value="{{ __('Filtrer par date') }}" />
                     <x-input class="" type='date'
                              placeholder="Lieu de naissance" wire:model='date_to_search'/>
                     @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                 </div>
                 <div class="form-group pr-4">
                     <x-label value="{{ __('Filtrer par moi') }}" />
                     <x-select wire:model='month'>
                         @foreach ($months as $m)
                             <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
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
             </div>

         </div>
     </div>
     </div>
    </div>
    <div class="card">
     <div class="card-body">
         <h5 class="card-title">Evolution paiement inscription</h5>
         <div id="chart-dash-fin-insc"></div>
     </div>
     <div class="card">
         <div class="card-body">
             <h5 class="card-title">Evolution paiement frais</h5>
             <div id="chart-dash-fin-paie"></div>
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
         series: [{
             name: 'Montant',
             data: @json($amountDataX)
         },
     ],
         xaxis: {
             categories: @json($monthsDataY)
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
         series: [{
             name: 'Montant',
             data: @json($amountPaieDataX)
         },
     ],
         xaxis: {
             categories: @json($monthsPaieDataY)
         }

     }
     var chart = new ApexCharts(document.querySelector("#chart-dash-fin"), options);
     var chart2 = new ApexCharts(document.querySelector("#chart-dash-fin-insc"), options2);
     var chart3 = new ApexCharts(document.querySelector("#chart-dash-fin-paie"), options3);
     chart2.render();
     chart3.render();
     chart.render();


 </script>
