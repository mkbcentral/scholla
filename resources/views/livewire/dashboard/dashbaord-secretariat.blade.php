<div>
    <div class="card">
        <div class="card-body">
           <div class="d-flex justify-content-between align-items-center">
                <div> <h4>&#x1F4C9; Evolution par section</h4></div>
                <div><h3 class="text-primary">&#x1F4C1; Total inscrit: {{$newInsc+$oldInsc}}</h3></div>
           </div>
            <div class="row mt-4">
                @foreach ($sections as $section)
                    <div class="col-md-3">
                        <!-- small box -->
                        <div class="small-box
                                {{$section->name=='Primaire'?'bg-primary':''}}
                                {{$section->name=='Secondaire'?'bg-warning':''}}
                                {{$section->name=='Maternelle'?'bg-success':''}}
                                ">
                        <div class="inner">
                            <h3>{{$section->getInscriptionCount($section->id)}}</h3>
                            <h4>{{$section->name}}</h4>
                        </div>
                      <a  class="small-box-footer"> <span class="p-2"></span></a>
                    </div>
                  </div>
                @endforeach

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card-body">
                        <h4>&#x1F4C8; Evolution detaillée</h4>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                    <!-- small box -->
                                <div class="small-box bg-danger
                                            ">
                                    <div class="inner">
                                        <h3>{{$newInsc}}</h3>
                                        <h4>Nouvelle Inscription</h4>
                                    </div>
                                  <a  class="small-box-footer"> <span class="p-2"></span></a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- small box -->
                            <div class="small-box bg-secondary
                                        ">
                                <div class="inner">
                                    <h3>{{$oldInsc}}</h3>
                                    <h4>Réinscription</h4>
                                </div>
                              <a  class="small-box-footer"> <span class="p-2"></span></a>
                            </div>
                        </div>
                        </div>
                    </div>
                    <table class="table table-light">
                        <thead class="thead-light">
                            <tr>
                                <th>Type</th>
                                <th class="text-center">Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inscriptions as $inscription)
                                <tr>
                                    <td>{{$inscription->name}}</td>
                                    <td class="text-center text-danger text-bold">{{$inscription->total}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="" id="chart-dash2"></div>
                    <div class="" id="chart-dash"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script setup>

    var chart = new ApexCharts(document.querySelector("#chart-dash"), options);
    var chart2 = new ApexCharts(document.querySelector("#chart-dash2"), options2);
    chart2.render();
    chart.render();
</script>
