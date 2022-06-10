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
            <button class="bkt-button primary-outline d-none d-md-block" data-bs-toggle="modal" data-bs-target="#authModal">
                Вход и регистрация
            </button>
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
                <li class="bkt-navbar__nav-item d-none d-lg-flex">
                    <a class="bkt-navbar__nav-link" href="#">Топ-побед</a>
                </li>
                <li class="bkt-navbar__nav-item d-none d-lg-flex">
                    <a class="bkt-navbar__nav-link" href="#">Реестры</a>
                </li>
                <li class="bkt-navbar__nav-item d-none d-lg-flex">
                    <a class="bkt-navbar__nav-link" href="#">Контакты</a>
                </li>
                <li class="bkt-navbar__nav-item d-flex d-lg-none">
                    <a class="bkt-navbar__nav-link" href="#">Тарифы</a>
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
                         <bkt-icon :name="'Menu'" />
                    </span>
                </button>
            </div>
        </div>

    </nav>
</header>

<bkt-auth-modal></bkt-auth-modal>
