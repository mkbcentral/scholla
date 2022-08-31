<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger">  &#x1F3D8; GESTIONNAIRE ECOLE</h1>
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
                            <a class="nav-link active" href="#section" data-toggle="tab">
                                <i class="fas fa-file-alt"></i> Gestion des sections
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#option" data-toggle="tab">
                                <i class="fas fa-list-alt"></i> Gestion des options
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#classe" data-toggle="tab">
                            <i class="fas fa-house-damage    "></i> Gestion des classes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#year" data-toggle="tab">
                                <i class="fas fa-address-card"></i> Gestion année scolaire
                            </a>
                        </li>
                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="section">
                        <div>
                            @livewire('school.section-page')
                        </div>
                        </div>
                        <div class=" tab-pane" id="option">
                            <div>
                                @livewire('school.option-page')
                            </div>
                        </div>
                        <div class=" tab-pane" id="classe">
                            <div>
                                @livewire('school.classe-page')
                            </div>
                        </div>
                        <div class=" tab-pane" id="year">
                            <div>
                                @livewire('school.scolary-year-page')
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
