<div>
    <x-loading-indicator />
    <div class="content-header">
        <div class="container-fluid">
        <div class="">
            <div class="d-flex justify-content-between">
                <div>
                    <h1 class="m-0 text-danger text-uppercase"> &#x1F5C3;  Linsting des élèves</h1>
                </div>
                <div>
                    <div class="form-group">
                        <label for="my-select">Anné scolaire</label>
                          <div class="input-group date"  >
                            <select id="my-select" class="form-control" wire:model.defer='scolary_id'>
                                <option >Choisir...</option>
                                @foreach ($scolaryyears as $year)
                                    <option wire:click.prevent='changeScolaryid' value="{{$year->id}}">{{$year->name}}</option>
                                @endforeach
                            </select>
                              <div class="input-group-append" >
                                    <button wire:click='changeScolaryid' class="btn btn-info" type="button"><i class="fa fa-search"></i></button>
                              </div>
                          </div>
                      </div>
                </div>
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
                    @foreach ($options as $option)
                        <li class="nav-item">
                            <a wire:click.prevent='changeIndex({{$option}})'
                                class="nav-link {{$selectedIndex==$option->id?'active':''}} "
                                 href="#inscription" data-toggle="tab">
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
                            <div class="form-group ">
                                <x-label value="{{ __('Filtrer par par classe') }}" />
                                <x-select wire:model='classe_id'>
                                    <option value="">Choisir...</option>
                                    @foreach ($classes as $classe)
                                        <option value="{{$classe->id}}">{{$classe->name.'/'.$classe->option->name}}</option>
                                    @endforeach
                                </x-select>
                            </div>
                            <div></div>
                            <div class="mr-4">
                               @if ($classe_id !=0)
                                    <a  class="mt-4 btn btn-secondary" target="_blank" href="{{ route('students.print', $classe_id) }}">
                                        &#x1F5A8;
                                        Imprimer
                                    </a>
                               @endif
                            </div>
                       </div>
                       <div class="d-flex justify-content-end">
                            <a href="#" wire:click.prevent='isRefresh' class="mr-2"><i class="fa fa-refresh" aria-hidden="true"></i>Actualiser</a>
                            <a href="#" wire:click.prevent='isBascule' class="mr-2"><i class="fa fa-eye" aria-hidden="true"></i>Voir bacsule</a>
                            <a href="#" wire:click.prevent='isAbondon' class="mr-2"><i class="fa fa-eye" aria-hidden="true"></i>Voir abandon</a>
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
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des élèves</h4></div>
                            <div class="d-flex justify-content-end">
                                <div class="w-25">
                                    <div class="card-tools">
                                        <div class="input-group input-group-sm">
                                          <input wire:model.debounce.500ms='keySearch' type="text" class="form-control" placeholder="Recheche ici...">
                                          <div class="input-group-append">
                                            <div class="btn btn-primary">
                                              <i class="fas fa-search"></i>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">

                            <table class="table table-stripped table-sm ">
                                <thead class="thead-light">
                                    <tr class="text-uppercase">
                                        <th>N°</th>
                                        <th>Noms élèves</th>
                                        <th>Calsse</th>
                                        <th class="text-center">Genre</th>
                                        <th class="text-center">Age</th>
                                        <th class="text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inscriptions as $index=> $inscription)
                                        <tr>
                                            <td>{{ $index+1}}</td>
                                            <td>{{$inscription->student->name}}</td>
                                            <td>{{$inscription->student->classe->name.'/'.$inscription->student->classe->option->name}}</td>
                                            <td class="text-center">{{$inscription->student->gender}}</td>
                                            <td class="text-center">
                                                @if (date('Y')-$inscription->student->date_of_birth->format('Y')==0)
                                                    <span class="text-danger">Inconu</span>
                                                @elseif(date('Y')-$inscription->student->date_of_birth->format('Y')==1)
                                                    {{date('Y')-$inscription->student->date_of_birth->format('Y')}} An
                                                @else
                                                    {{date('Y')-$inscription->student->date_of_birth->format('Y')}} Ans
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->roles->pluck('name')->contains('Secretaire') or Auth::user()->roles->pluck('name')->contains('root'))
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
                                                    <x-button wire:click.prevent='showDeleteStudent({{$inscription}},{{$inscription->student}})'
                                                        class="text-danger"><i class="fa fa-trash" aria-hidden="true"></i>
                                                    </x-button>
                                                    @if ($isAbondon==false)
                                                            @if ($inscription->is_bascule==false)
                                                            <x-button wire:click.prevent='markIsBascule({{$inscription}})'
                                                                class="text-danger"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                                                            </x-button>
                                                        @else
                                                            <x-button wire:click.prevent='markIsBascule({{$inscription}})'
                                                                class="text-info"><i class="fa fa-arrow-left" aria-hidden="true"></i>
                                                            </x-button>
                                                        @endif
                                                    @endif
                                                    @if ($isBascule==false)
                                                        @if ($inscription->is_bascule==true)
                                                            <x-button wire:click.prevent='showActiveStudent({{$inscription}})'
                                                                class="text-info"><i class="fa fa-check" aria-hidden="true"></i>
                                                            </x-button>
                                                        @else
                                                            <x-button wire:click.prevent='showActiveStudent({{$inscription}})' class="text-info">
                                                                <i class="fa fa-times" aria-hidden="true"></i>
                                                            </x-button>
                                                        @endif
                                                    @endif

                                                @else
                                                    <x-button wire:click.prevent='editInfos({{$inscription->student}})'
                                                        class="btn-sm text-secondary" type="button" data-toggle="modal"
                                                        data-target="#showStudentInfos">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </x-button>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                       </div>
                    </div>
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              @include('livewire.inscription.modals.show-infos')
              @include('livewire.inscription.modals.form-edit-inscription')
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->

</div>
