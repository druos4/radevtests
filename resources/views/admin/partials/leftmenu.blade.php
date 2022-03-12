<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class="nav-item {{ request()->is('admin') ? 'active' : '' }}"><a class="d-flex align-items-center" href="/admin"><i data-feather="home"></i><span class="menu-title text-truncate" data-i18n="Home">Админпанель</span></a>
            </li>

            @if(auth()->user()->hasRole(['admin', 'manager']))
            <li class="nav-item {{ request()->is('admin/tests*') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="/admin/tests">
                    <i data-feather="tag"></i><span class="menu-title text-truncate" data-i18n="Тесты">Тесты</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasRole('admin'))
                <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
                    <a class="d-flex align-items-center" href="/admin/users">
                        <i data-feather="users"></i><span class="menu-title text-truncate" data-i18n="Пользователи">Пользователи</span>
                    </a>
                </li>
            @endif
        </ul>
    </div>
</div>
