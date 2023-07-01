<div>
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger"> &#x1F5C3; GESTIONNAIRE DES INSCRIPTIONS</h1>
            </div>
        </div>
        </div>
    </div>
    @livewire('application.inscription.forms.create-new-inscription-form')
    @livewire('application.inscription.forms.edit-inscription-form')
     <!-- Main content -->
     <section class="content">
        <div class="container-fluid">
          <div class="row">

            <!-- /.col -->
            <div class="col-md-12">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    @foreach ($optionList as $option)
                        <li class="nav-item">
                            <a wire:click.prevent='changeIndex({{$option}})'
                                 class="nav-link {{$selectedIndex==$option->id?'active':''}} " href="#inscription" data-toggle="tab">
                                &#x1F4C2; {{$option->name}}
                            </a>
                        </li>
                    @endforeach

                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="inscription">
                       <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group w-25">
                                <x-label value="{{ __('Filtrer par par classe') }}" />
                                <x-select wire:model='classe_id'>
                                    <option value="">Choisir...</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <x-label value="{{ __('Filtrer par date') }}" />
                                    <x-input class="" type='date'
                                             placeholder="Lieu de naissance" wire:model='date_to_search'/>
                                </div>
                            </div>
                            <div>
                                <x-button  class="btn-primary mt-4" wire:click.prevent='shwoFormCreate' type="button" data-toggle="modal"
                                data-target="#formInscriptionModal">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            Nouvelle inscription
                        </x-button>
                            </div>

                       </div>
                       <div>
                        @if ($inscriptions->isEmpty())
                            <span class="text-success text-center p-4">
                                <h4><i class="fa fa-database" aria-hidden="true"></i>
                                         Selection une classe SVP !
                                </h4>
                            </span>
                        @else
                        <div>
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des inscriptions jurnalières</h4></div>
                        </div>
                        <table class="table table-stripped table-sm mt-4">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>Noms élève</th>
                                    <th class="text-center">Genre</th>
                                    <th class="text-center">Age</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscriptions as $inscription)
                                    <tr>
                                        <td>{{$inscription->student->name.'/'.$inscription->classe->name.' '.$inscription->classe->classeOption->name}}</td>

                                        <td class="text-center">{{$inscription->student->gender}}</td>
                                        <td class="text-center">
                                           1
                                        </td>
                                        <td class="text-center">
                                            <x-button wire:click.prevent='edit({{$inscription->student}},{{$inscription}})'
                                                class="btn-sm" type="button" data-toggle="modal"
                                                data-target="#formEditInscriptionModal">
                                               <i class="fas fa-edit text-primary"></i>
                                            </x-button>
                                            <x-button wire:click.prevent='editInfos({{$inscription->student}})'
                                                class="btn-sm text-secondary" type="button" data-toggle="modal"
                                                data-target="#showStudentInfos">
                                              <i class="fa fa-eye" aria-hidden="true"></i>
                                            </x-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endif
                       </div>
                    </div>
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              @include('livewire.inscription.modals.show-infos')
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->

</div>
