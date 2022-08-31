<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light text-upercase">
            {{config('app.name','MASOMO')}}
        </span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <x-nav-link class="nav-link" href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        &#x1F4C8;
                        Dashboard
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('school.index') }}" :active="request()->routeIs('school.index')">
                        &#x1F3EB;
                        Gestionnaire écoles
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('cost.index') }}" :active="request()->routeIs('cost.index')">
                        &#x1F4B0;
                        Gestionnaire des frais
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('inscription.index') }}" :active="request()->routeIs('inscription.index')">
                        &#x1F4C1;
                        Gestionnaire inscriptions
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('listing.index') }}" :active="request()->routeIs('listing.index')">
                        &#x1F5C3;
                        Listing élèves
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('evolution.index') }}" :active="request()->routeIs('evolution.index')">
                       &#x1F4C8;
                        Evolution inscription
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('paiment.inscription') }}" :active="request()->routeIs('paiment.inscription')">
                        &#x1F4B8;
                        Paiment frais insc.
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('paiment.cost') }}" :active="request()->routeIs('paiment.cost')">
                        &#x1F4B8;
                        Paiment autres frais
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('paie.papport.inscription.mounth') }}" :active="request()->routeIs('paie.papport.inscription.mounth')">
                        &#x1F4C3;
                        Rapport paiment insc.
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('paie.papport.frais.mounth') }}" :active="request()->routeIs('paie.papport.frais.mounth')">
                        &#x1F4C3;
                        Rapport autres frais.
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('control.index') }}" :active="request()->routeIs('control.index')">
                        &#x2611;
                        Controle paiement
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('bank.index') }}" :active="request()->routeIs('bank.index')">
                        &#x1F6BC;
                       Mouvements banques
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('bank.index') }}" :active="request()->routeIs('bank.index')">
                        &#x1F6BC;
                       Mouvements banques
                    </x-nav-link>
                    <x-nav-link class="nav-link" href="{{ route('admin.index') }}" :active="request()->routeIs('admin.index')">
                        &#x1F9B8;
                       Administration
                    </x-nav-link>
                </li>
            </ul>
        </nav>
    </div>
</aside>
