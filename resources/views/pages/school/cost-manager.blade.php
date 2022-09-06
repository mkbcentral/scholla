<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger"> &#x1F4B8; GESTION DES FRAIS SCOLAIRE</h1>
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
                            <a class="nav-link active" href="#inscription" data-toggle="tab">
                                &#x1F4B0; Frais inscription
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#otherCost" data-toggle="tab">
                                &#x1F4B0; Autres frais
                            </a>
                        </li>
                        @if (Auth::user()->roles->pluck('name')->contains('Admin') or
                            Auth::user()->roles->pluck('name')->contains('root'))
                            <li class="nav-item">
                                <a class="nav-link " href="#devise" data-toggle="tab">
                                    &#x1F4B8; Devise
                                </a>
                            </li>
                        @endif

                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="active tab-pane" id="inscription">
                           <div>
                              @livewire('cost.cost-inscription-page')
                           </div>
                        </div>
                        <div class=" tab-pane" id="otherCost">
                            <div>
                               @livewire('cost.cost-other-page')
                            </div>
                         </div>
                         <div class=" tab-pane" id="devise">
                            <div>
                              @livewire('cost.cost-devise-page')
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
