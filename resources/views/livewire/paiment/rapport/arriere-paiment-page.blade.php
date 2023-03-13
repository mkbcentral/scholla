<div>
    <x-loading-indicator />
    <div class="form-group pr-4">
        <x-label value="{{ __('Filtrer par mois') }}" />
        <x-select wire:model='month'>
            @foreach ($months as $m)
                <option value="{{$m}}">{{strftime('%B', mktime(0, 0, 0, $m,10))}}</option>
            @endforeach
        </x-select>
    </div>
    @php
        $total=0;
    @endphp
    <table class="table table-light">
        <thead class="thead-light">
            <tr>
                <th>#</th>
                <th>DATE PAIMENT</th>
                <th>ELEVE</th>
                <th>MOTIF</th>
                <th class="text-right">MONTANT</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($arrieres as $index => $arriere)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $arriere->created_at->format('d/m/Y')}}/<span class="text-primary text-bold">{{ strftime('%B', mktime(0, 0, 0, $arriere->mounth_name,10) ) }}</span></td>
                    <td>{{ $arriere->student->name.'/'.$arriere->student->classe->name.'/'.$arriere->student->classe->option->name }}</td>
                    <td>{{ $arriere->cost->name }}</td>
                    <td class="text-right">{{ number_format($arriere->cost->amount*2000,1,',',' ')  }}</td>
                </tr>
                @php
                    $total+=$arriere->cost->amount*2000;
                @endphp
            @endforeach
        </tbody>

    </table>

    <div class="card ">
        <div class="card-body d-flex justify-content-end ">
            <h3 class="text-right">Total: {{number_format($total,1,',',' ')}} Fc</h3>
        </div>
    </div>
</div>
