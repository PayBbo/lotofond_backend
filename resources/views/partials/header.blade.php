<!-- Page Header-->
<header class="">
    <nav class="bkt-navbar">
        <div class="bkt-container bkt-navbar__wrapper">
            <button class="bkt-button blue">
                Покупка без ЭЦП
            </button>
            <ul class="bkt-navbar__nav d-none d-lg-flex">
                <li class="bkt-navbar__nav-item">
                    <a class="bkt-navbar__nav-link" href="#">
                    <span class="bkt-button-ellipse main">
                        <bkt-icon :name="'Star'" :fill="'#ffc515'"/>
                    </span>
                        Топ-Избранное
                    </a>
                </li>
                <li class="bkt-navbar__nav-item">
                    <a class="bkt-navbar__nav-link" href="#">
                    <span class="bkt-button-ellipse main">
                         <bkt-icon :name="'Target'" :stroke="'#ec4c27'"/>
                    </span>
                        Мониторинг
                    </a>
                </li>
                <li class="bkt-navbar__nav-item">
                    <a class="bkt-navbar__nav-link" href="#">
                    <span class="bkt-button-ellipse main">
                        <span class="info"></span>
                        <bkt-icon :name="'Bell'" :fill="'#2fbb40'"/>
                    </span>
                        Сообщения
                    </a>
                </li>
            </ul>
            <button class="bkt-button primary">
                Приложение
            </button>
            @if(Auth::user())
                <div class="btn-group d-none d-md-block">
                    <div class="bkt-navbar__user-wrapper"
                         id="navbarDropdown"
                         role="button"
                         data-bs-toggle="dropdown"
                         aria-haspopup="true"
                         aria-expanded="false">

                        <div class="bkt-navbar__user text-truncate me-1">
                            <div class="bkt-navbar__user-name text-truncate">
                                {{Auth::user()->name}} {{Auth::user()->surname}}
                            </div>
                            <div class="bkt-navbar__user-tarif">
                                тариф: <span class="bkt-navbar__user-tarif-name">Базовый</span>
                            </div>
                        </div>
                        <div class="bkt-navbar__user-icon">
                            <bkt-icon :name="'ArrowDown'"></bkt-icon>
                        </div>
                    </div>
                    <div class="dropdown-menu dropdown-menu-right bkt-navbar__user-dropdown"
                         aria-labelledby="navbarDropdown">
                        <div class="bkt-navbar__user-dropdown-menu">
                            <button class="bkt-button bkt-tarif-button">Сменить тариф</button>
                            <div class="bkt-navbar__user-dropdown-item">
                                <div class="bkt-navbar__user-dropdown-item-icon bg-primary-lighter">
                                    <bkt-icon :name="'User'" :fill="'#2953ff'"></bkt-icon>
                                </div>
                                <a class="bkt-navbar__user-dropdown-item-text" href="#">Профиль</a>
                            </div>
                            <div class="bkt-navbar__user-dropdown-item">
                                <div class="bkt-navbar__user-dropdown-item-icon bg-red-lighter">
                                    <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                         width="100%" height="100%" viewBox="0 0 512.000000 512.000000"
                                         preserveAspectRatio="xMidYMid meet">
                                        <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                           fill="#ec4c27" stroke="none">
                                            <path d="M161 5103 c-59 -21 -124 -87 -144 -148 -16 -45 -17 -237 -17 -2395 0
                                            -2633 -7 -2404 75 -2485 80 -80 -21 -75 1430 -75 1451 0 1350 -5 1430 75 98
                                            98 98 252 0 350 -79 80 4 75 -1287 75 l-1148 0 0 2060 0 2060 1148 0 c1291 0
                                            1208 -5 1287 75 98 98 98 252 0 350 -80 80 22 75 -1434 74 -1147 0 -1301 -2
                                            -1340 -16z"/>
                                            <path d="M3520 4065 c-136 -44 -208 -205 -149 -335 15 -34 127 -152 457 -482
                                            l437 -438 -1216 0 c-1366 0 -1274 5 -1354 -75 -98 -98 -98 -252 0 -350 80 -80
                                            -12 -75 1354 -75 l1216 0 -437 -437 c-240 -241 -444 -454 -454 -473 -27 -51
                                            -25 -162 3 -216 25 -47 82 -101 129 -120 48 -20 151 -17 200 5 61 28 1354
                                            1315 1386 1379 32 65 32 159 0 224 -30 60 -1320 1347 -1384 1379 -52 27 -131
                                            33 -188 14z"/>
                                        </g>
                                    </svg>

                                </div>
                                <div class="bkt-navbar__user-dropdown-item-text">Выйти</div>
                            </div>
                        </div>

                    </div>
                </div>
            @else
                <button class="bkt-button primary-outline d-none d-md-block" data-bs-toggle="modal"
                        data-bs-target="#authModal">
                    Вход и регистрация
                </button>
            @endif
        </div>

    </nav>
    <nav class="bkt-navbar white">
        <div class="bkt-navbar__wrapper bkt-container">
            <div class="bkt-navbar__wrapper d-none d-lg-flex">
                <button class="bkt-button primary-lighter">
                    Торги
                </button>
                <button class="bkt-button blue-lighter">
                    Тарифы
                </button>
            </div>
            <div class="bkt-navbar__logo d-flex d-lg-none">
                LOGO
            </div>
            <ul class="bkt-navbar__nav">
                <li class="bkt-navbar__nav-item d-none d-lg-flex">
                    <a class="bkt-navbar__nav-link" href="#">Купить через агента</a>
                </li>
                <li class="bkt-navbar__nav-item">
                    <a class="bkt-navbar__nav-link" href="#">
                    <span class="bkt-navbar__nav-icon">
                         <bkt-icon :name="'Fire'" :width="'22px'" :height="'22px'"/>
                    </span>
                        Горящие торги
                    </a>
                </li>
                <li class="bkt-navbar__nav-item d-none d-md-flex">
                    <a class="bkt-navbar__nav-link" href="#">Топ-побед</a>
                </li>
                <li class="bkt-navbar__nav-item d-none d-md-flex">
                    <a class="bkt-navbar__nav-link" href="#">Реестры</a>
                </li>
                <li class="bkt-navbar__nav-item d-none d-lg-flex">
                    <a class="bkt-navbar__nav-link" href="#">Контакты</a>
                </li>
                <li class="bkt-navbar__nav-item d-flex d-lg-none">
                    <a class="bkt-navbar__nav-link" href="#">Тарифы</a>
                </li>
            </ul>
            <div class="bkt-navbar__wrapper">
                <button class="bkt-button red-outline d-none d-lg-flex">
                    <span class="bkt-button__icon mx-2">
                         <bkt-icon :name="'Law'" :width="'16px'" :height="'16px'"/>
                    </span>
                    Изменения в законах
                </button>
                <button class="bkt-button-ellipse m-0 d-flex d-lg-none">
                    <span class="bkt-button__icon">
                         <bkt-icon :name="'Menu'"/>
                    </span>
                </button>
            </div>
        </div>

    </nav>
</header>

<bkt-auth-modal></bkt-auth-modal>
<bkt-code-modal></bkt-code-modal>
