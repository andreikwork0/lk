<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark noprint"  style="width: 280px; height: 100vh;">
    <a href="/" class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            @svg('person-square', 'w-50 h-10  text-white')
        <span class="fs-4 mx-2 d-inline-block">Сотрудник</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">




        <li>
            <a href="{{route('tabulagram.show')}}" class="nav-link text-white @if(request()->routeIs('tabulagram.*')) {{'active'}} @endif">
                @svg('wallet', 'w-16 h-16 bi me-2 text-white')
                Табулеграмма
            </a>
        </li>


        @roleis('admin')
        <li>
            <a href="{{route('users.index')}}" class="nav-link text-white @if(request()->routeIs('users.*')) {{'active'}} @endif">
                @svg('person-lines-fill', 'w-16 h-16 bi me-2 text-white')
                Пользователи
            </a>
        </li>
        <li>
            <a href="{{route('settings.index')}}" class="nav-link text-white @if(request()->routeIs('settings.*')) {{'active'}} @endif">
                @svg('gear', 'w-16 h-16 bi me-2 text-white')
                Настройки
            </a>
        </li>
        @endroleis
    </ul>

</div>
