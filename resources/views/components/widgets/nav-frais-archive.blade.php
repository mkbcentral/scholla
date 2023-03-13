<div>
    <li class="nav-item" >
        <a href="#" class="nav-link " >
            <i class="fa fa-folder" aria-hidden="true"></i>
          <p>
            Archive frais
            <i class="fas fa-angle-left right"></i>
          </p>
        </a>
        <ul class="nav nav-treeview" >
            <x-nav-link class="nav-link" href="{{ route('archive.juin') }}" :active="request()->routeIs('archive.juin')">
                <i class="fa fa-file" aria-hidden="true"></i>
                Archive juin
             </x-nav-link>
             <x-nav-link class="nav-link" href="{{ route('archive.juin.global') }}" :active="request()->routeIs('archive.juin.global')">
                <i class="fa fa-file" aria-hidden="true"></i>
                Archive juin global
             </x-nav-link>
        </ul>
    </li>
</div>
