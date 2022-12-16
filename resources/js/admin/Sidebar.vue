<template>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="#" class="brand-link">
            <img src="/assets/admin_lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                 class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">Админ-панель</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <router-link to="/admin/dashboard" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>
                                Главная
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/users" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Пользователи
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/roles" class="nav-link">
                            <i class="nav-icon fa fa-cubes"></i>
                            <p>
                                Роли
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/text-data" class="nav-link">
                            <i class="nav-icon fa fa-cogs"></i>
                            <p>
                               Текстовые данные
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/contacts" class="nav-link">
                            <i class="nav-icon fa fa-envelope"></i>
                            <p>
                               Почты для рассылки
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/applications" class="nav-link">
                            <i class="nav-icon fa fa-question-circle"></i>
                            <p>
                                Заявки
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/lots" class="nav-link">
                            <i class="nav-icon fa fa-archive"></i>
                            <p>
                                Лоты
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/tariffs" class="nav-link">
                            <i class="nav-icon fa fa-tags"></i>
                            <p>
                                Тарифы
                            </p>
                        </router-link>
                    </li>

                    <li class="nav-item">
                        <router-link to="/admin/content-rules" class="nav-link">
                            <i class="nav-icon fa fa-ban"></i>
                            <p>
                                Ограничения контента
                            </p>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/admin/egrn-statements" class="nav-link">
                            <i class="nav-icon fa fa-book"></i>
                            <p>
                                Отчеты ЕГРН
                            </p>
                        </router-link>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>

<script>
export default {
    name: "Sidebar"
}
</script>

<style scoped>

</style>
