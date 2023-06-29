<div>
    <x-loading-indicator />
    @php
        $total = 0;
    @endphp
    <!-- Main content -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="text-uppercase text-primary">&#x1F5C2; Situation frais de l'état global</h4>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="inscription">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="form-group pr-4">
                                            <x-label value="{{ __('Filtrer par mois') }}" />
                                            <x-select wire:model='month'>
                                                @foreach ($months as $m)
                                                    <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                        <div class="form-group pr-4">
                                            <x-label value="{{ __('Choisir la section') }}" />
                                            <x-select wire:model='section_id'>
                                                <option value="0">Choisir...</option>
                                                @foreach ($sections as $section)
                                                    <option value="{{$section->id}}">{{$section->name}}</option>
                                                @endforeach
                                            </x-select>
                                        </div>
                                    </div>
                                    <div>
                                        @if ($paiments->isEmpty())
                                            <span class="text-success text-center p-4">
                                                <h4><i class="fa fa-database" aria-hidden="true"></i>
                                                    Filtre invalide SVP !
                                                </h4>
                                            </span>
                                        @else
                                            <table class="table table-stripped table-sm">
                                                <thead class="thead-light">
                                                    <tr class="text-uppercase">
                                                        <th>N°</th>
                                                        <th>Date paiment.</th>
                                                        <th>Noms élèves</th>
                                                        <th>Type</th>
                                                        <th class="text-right">Montant</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($paiments as $index => $paiment)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $paiment->created_at->format('d/m/Y') }}</td>
                                                            <td>{{ $paiment->student->name }}</td>
                                                            <td>{{ $paiment->cost->name }}</td>
                                                            <td class="text-right">
                                                                {{ number_format($paiment->cost->amount * 2000, 1, ',', ' ') }}
                                                            </td>
                                                        </tr>
                                                        @php
                                                            $total += $paiment->cost->amount * 2000;
                                                        @endphp
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                        <div class="card ">
                                            <div class="card-body d-flex justify-content-end ">
                                                <div>
                                                    <h3 class="">Total:
                                                        {{ number_format($total, 1, ',', ' ') }} Fc
                                                    </h3>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @include('livewire.paiment.modals.add-sortie-frais-etat')
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
