<template>
    <fragment>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Страница не найдена</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <router-link to="/admin/dashboard"
                                             style="color: #007bff; text-decoration: none; background-color: transparent;">
                                    Главная страница
                                </router-link>
                            </li>
                            <li class="breadcrumb-item active">Страница не найдена</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="error-page">
                <h1 class="headline text-warning"> 404</h1>
                <div class="error-content">
                    <br>
                    <h3><i class="fas fa-exclamation-triangle text-warning"></i> Упс, страница не существует</h3>
                </div>

            </div>
        </section>
    </fragment>
</template>

<script>
export default {
    name: "Error404"
}
</script>

<style scoped>

</style>
