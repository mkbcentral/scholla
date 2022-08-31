<x-app-layout>
    <div>
        <div class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1 class="m-0 text-danger">  <i class="fas fa-users-cog"></i> ADMINISTRATION</h1>
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
                            <a class="nav-link active" href="#users" data-toggle="tab">
                                <i class="fas fa-users"></i> Gestion des utilisateurs
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#roles" data-toggle="tab">
                                <i class="fa fa-user-plus" aria-hidden="true"></i> Gestion des roles
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link " href="#settings" data-toggle="tab">
                                &#x1F5A5; Paramètres
                            </a>
                        </li>
                    </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="users">
                            <div>
                                @livewire('admin.user-component')
                            </div>
                        </div>
                        <div class=" tab-pane" id="roles">
                            <div>
                                @livewire('admin.role-component')
                            </div>
                        </div>
                        <div class=" tab-pane" id="settings">
                            <div>
                                @livewire('admin.setting-component')
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
