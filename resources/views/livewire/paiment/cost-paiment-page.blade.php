<div>
    <x-loading-indicator />
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1 class="m-0 text-danger text-uppercase">&#x1F4B0;  Paiement autres frais</h1>
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
                            <a wire:click.prevent='changeIndex({{$option}})' class="nav-link {{$selectedIndex==$option->id?'active':''}} " href="#inscription" data-toggle="tab">
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
                            <div></div>
                            <div class="mr-4">
                                <x-button
                                    wire:click.prevent='getGetPaiementDay'
                                    type="button"
                                    class="btn btn-info"
                                    data-toggle="modal"
                                    data-target="#showPaiementModal">
                                    Voire le paiment journalier
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
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des ??l??ves</h4></div>
                        </div>
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
                        <table class="table table-stripped table-sm mt-4">
                            <thead class="thead-light">
                                <tr class="text-uppercase">
                                    <th>N??</th>
                                    <th>Noms ??l??ves</th>
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
                                            @if (Auth::user()->roles->pluck('name')->contains('Secretaire'))

                                            @else

                                            @endif
                                            <button wire:click.prevent='show({{$inscription}})'
                                                        class="btn btn-sm btn-info" type="button"
                                                    data-toggle="modal"
                                                    data-target="#formPaiementModal">
                                                Passer paiment
                                            </button>
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
              @include('livewire.paiment.modals.paiement-form')
              @include('livewire.paiment.modals.show-paiement')
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->

</div>
