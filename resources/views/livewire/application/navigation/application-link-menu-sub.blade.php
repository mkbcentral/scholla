<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <span class="brand-text font-weight-light text-upercase">
            {{ config('app.name', 'MASOMO') }}
        </span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <x-nav-link class="nav-link" href="{{ route('dashboard') }}">
                        &#x1F4C8;
                        <p>Dashboard</p>
                    </x-nav-link>
                    @foreach ($menuSubLinkList as $menu)
                        <x-nav-link class="nav-link" href="{{ route($menu->link) }}" :active="request()->routeIs($menu->link)">
                           <i class="fa {{$menu->icon}}"></i>
                            <p>{{$menu->name}}</p>
                        </x-nav-link>
                    @endforeach
                </li>
            </ul>
        </nav>
    </div>
</aside>
