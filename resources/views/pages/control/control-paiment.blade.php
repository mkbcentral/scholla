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
                            <a class="nav-link active" href="#notpaiment" data-toggle="tab">
                                <i class="fas fa-file-alt"></i> Pas en ordre
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#paiment" data-toggle="tab">
                                <i class="fas fa-file-alt"></i> En ordre
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#otherNot" data-toggle="tab">
                                <i class="fas fa-file-alt"></i> Frais de l'état et connxes pas en ordre
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#other" data-toggle="tab">
                                <i class="fas fa-file-alt"></i> Frais de l'état et connxes en ordre
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#general" data-toggle="tab">
                                <i class="fas fa-file-alt"></i>Control général
                            </a>
                        </li>
                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="notpaiment">
                          @livewire('control.not-paiement-page')
                        </div>
                        <div class=" tab-pane" id="paiment">
                            @livewire('control.is-paiment')
                        </div>
                        <div class=" tab-pane" id="otherNot">

                           @livewire('control.other-controle-not-paiement')
                        </div>
                        <div class=" tab-pane" id="other">
                            @livewire('control.other-controle-paiement')
                         </div>
                         <div class=" tab-pane" id="general">
                            @livewire('control.general-control')
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
