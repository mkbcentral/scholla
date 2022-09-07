<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger"> &#x1F4B8; RAPPORT PAIEMENT AUTRES FRAIS</h1>
                </div>
            </div>
            </div>
        </div>

         <!-- Main content -->
         <section class="content">
            <div class="container-fluid">
              <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                  <div class="card">
                    <div class="card-header p-2">
                      <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a class="nav-link " href="#mouth" data-toggle="tab">
                               &#x1F4B8; Paiment mensuels minerval
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active " href="#bus" data-toggle="tab">
                                &#x1F4B0; Paiement mensuel bus et autres
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="#global" data-toggle="tab">
                                &#x1F4B0; Paiment minerval global
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link  " href="#global-other" data-toggle="tab">
                                &#x1F4B0; Paiment  global bus et autres
                            </a>
                        </li>
                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        <div class=" tab-pane" id="mouth">
                           <div>
                                @livewire('paiment.rapport.rapport-paiment-frais-page')
                           </div>
                        </div>
                        <div class="active tab-pane" id="bus">
                            <div>
                                @livewire('paiment.rapport.rapport-bus-page')
                            </div>
                         </div>
                        <div class=" tab-pane " id="global">
                            <div>
                                @livewire('paiment.rapport.rapport-paiment-frais-global-page')
                            </div>
                         </div>
                         <div class=" tab-pane " id="global-other">
                            <div>
                                @livewire('paiment.rapport.rapport-bus-global-page')
                            </div>
                         </div>
                      </div>
                      <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                  </div>
                  <!-- /.card -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
          <!-- /.content -->
    </div>
</x-app-layout>
