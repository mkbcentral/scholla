<div>
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
                                <div class="form-group pr-4">
                                    <x-label value="{{ __('Filtrer par moi') }}" />
                                    <x-select wire:model='month'>
                                        @foreach ($months as $m)
                                            <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m))}}</option>
                                        @endforeach
                                    </x-select>
                                </div>
                            </div>
                       </div>
                       <div>
                        @if ($students->isEmpty())
                            <span class="text-success text-center p-4">
                                <h4><i class="fa fa-database" aria-hidden="true"></i>
                                         Selection une classe SVP !
                                </h4>
                            </span>
                        @else
                        <div>
                            <div><h4 class="text-uppercase text-bold text-danger">Liste des élèves</h4></div>
                        </div>
                        <div class="d-flex justify-content-end">
                            Search
                        </div>
                        <table class="table table-stripped table-sm mt-4">
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
                                @foreach ($students as $index=> $student)
                                    @if ($student->paiement==null)
                                    <tr>
                                        <td>{{ $index+1}}</td>
                                        <td>{{$student->name}}</td>
                                        <td>{{$student->classe->name.'/'.$student->classe->option->name}}</td>
                                        <td class="text-center">{{$student->gender}}</td>
                                        <td class="text-center">
                                            @if (date('Y')-$student->date_of_birth->format('Y')==0)
                                                <span class="text-danger">Inconu</span>
                                            @elseif(date('Y')-$student->date_of_birth->format('Y')==1)
                                                {{date('Y')-$student->date_of_birth->format('Y')}} An
                                            @else
                                                {{date('Y')-$student->date_of_birth->format('Y')}} Ans
                                            @endif
                                        </td>
                                        <td class="text-center">

                                        </td>
                                    </tr>
                                    @endif

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
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
      <!-- /.content -->

</div>
