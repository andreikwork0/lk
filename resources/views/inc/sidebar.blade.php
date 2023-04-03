<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px; height: 100vh;">
    <a href="/" class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            @svg('person-workspace', 'w-50 h-10  text-white')
        <span class="fs-4 mx-2 d-inline-block">Личный кабинет сотрудника</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">





        @roleis('umu')
            <li>
                <a href="{{route('users.index')}}" class="nav-link text-white @if(request()->routeIs('users.*')) {{'active'}} @endif">
                    @svg('person-lines-fill', 'w-16 h-16 bi me-2 text-white')
                    Пользователи
                </a>
            </li>
        @endroleis

        @roleis('umu')
        <li>
            <a href="{{route('settings.index')}}" class="nav-link text-white @if(request()->routeIs('settings.*')) {{'active'}} @endif">
                @svg('gear', 'w-16 h-16 bi me-2 text-white')
                Настройки
            </a>
        </li>
        @endroleis
    </ul>

</div>
