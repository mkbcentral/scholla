<div>
    <li class="nav-item" >
        <a href="#" class="nav-link " >
            &#x1F5C3;
          <p>
            Frais de l'état
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview" >
            <x-nav-link class="nav-link" href="{{ route('rapport.frais.etat.date') }}" :active="request()->routeIs('rapport.frais.etat.date')">
                <i class="fa fa-calendar" aria-hidden="true"></i>
                Rapp. Frais Etat par jour
             </x-nav-link>
            <x-nav-link class="nav-link" href="{{ route('rapport.frais.etat') }}" :active="request()->routeIs('rapport.frais.etat')">
               <i class="fa fa-file" aria-hidden="true"></i>
               Rapp. Frais Etat/classe
            </x-nav-link>
            <x-nav-link class="nav-link" href="{{ route('rapport.frais.etat.section') }}" :active="request()->routeIs('rapport.frais.etat.section')">
                <i class="fa fa-file" aria-hidden="true"></i>
                Frais Etat/section
             </x-nav-link>
             <x-nav-link class="nav-link" href="{{ route('rapport.frais.etat.global') }}" :active="request()->routeIs('rapport.frais.etat.section')">
                <i class="fa fa-file" aria-hidden="true"></i>
                Frais Etat par section
             </x-nav-link>
        </ul>
    </li>
</div>
