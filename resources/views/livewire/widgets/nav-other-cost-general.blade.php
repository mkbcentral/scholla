<div>
    <li class="nav-item" >
        <a href="#" class="nav-link bg-info " >
            &#x1F5C3;
          <p>
            Rap. Gen. autres frais
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview text-center" >
            @foreach ($typeCosts as $type)
                <x-nav-link  class="nav-link"
                        href="{{ route('rapport.frais.type.general',$type->id) }}"
                            :active="request()->routeIs('rapport.frais.type.general',$type->id)">
                    {{$type->name}}
                </x-nav-link>
            @endforeach

        </ul>
    </li>
</div>
