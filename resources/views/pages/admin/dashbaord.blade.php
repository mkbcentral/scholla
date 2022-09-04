<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger">  &#x1F4CA; Tableau de bord</h1>
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
                        @if (Auth::user()->roles->pluck('name')->contains('Secretaire'))
                            <li class="nav-item">
                                <a class="nav-link active" href="#scolaire" data-toggle="tab">
                                    &#x1F5C3; Scolaire
                                </a>
                            </li>
                        @elseif (Auth::user()->roles->pluck('name')->contains('Finance'))
                            <li class="nav-item ">
                                <a class="nav-link active " href="#finance" data-toggle="tab">
                                    &#x1F4B0; Finance
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link active" href="#scolaire" data-toggle="tab">
                                    &#x1F5C3; Scolaire
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#finance" data-toggle="tab">
                                    &#x1F4B0; Finance
                                </a>
                            </li>
                        @endif

                      </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                      <div class="tab-content">
                        @if (Auth::user()->roles->pluck('name')->contains('Secretaire'))
                            <div class="active tab-pane" id="scolaire">
                                <div>
                                    @livewire('dashboard.dashbaord-secretariat')
                                </div>
                            </div>
                        @elseif (Auth::user()->roles->pluck('name')->contains('Finance'))
                            <div class=" tab-pane active" id="finance">
                                <div>
                                    @livewire('dashboard.dashbaord-finance-page')
                                </div>
                            </div>
                        @else
                            <div class="active tab-pane" id="scolaire">
                                <div>
                                    @livewire('dashboard.dashbaord-secretariat')
                                </div>
                            </div>

                            <div class=" tab-pane" id="finance">
                                <div>
                                    @livewire('dashboard.dashbaord-finance-page')
                                </div>
                            </div>
                        @endif

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
