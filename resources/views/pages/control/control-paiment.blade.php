<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger">  &#x2611; CONTROLE DE PAIMENT DES FRAIS</h1>
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
                            <a class="nav-link " href="#general" data-toggle="tab">
                                <i class="fas fa-file-alt"></i>Control général
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="active nav-link " href="#etat" data-toggle="tab">
                                <i class="fas fa-file-alt"></i>Control Frais de d'état
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#notEtat" data-toggle="tab">
                                <i class="fas fa-file-alt"></i>Control Frais de d'état pas en ordre
                            </a>
                        </li>
                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                    <div class="tab-content">
                         <div class="tab-pane" id="general">
                            @livewire('control.general-control')
                         </div>
                         <div class="active tab-pane" id="etat">
                            @livewire('control.frais-etat-control')
                         </div>
                         <div class="tab-pane" id="notEtat">
                            @livewire('control.not-frais-etat-control')
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
