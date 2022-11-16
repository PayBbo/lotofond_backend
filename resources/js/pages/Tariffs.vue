<template>
    <div class="container bkt-container col_div">
        <h1>Тарифы</h1>
        <div class="range">
            <div class="ticks">
                        <span class="tick current">1<span
                            class="tick-price">1&nbsp;000&nbsp;<span>₽</span></span></span>
                <span class="tick">2</span>
                <span class="tick">3<span class="tick-price">2&nbsp;750&nbsp;<span>₽</span></span></span>
                <span class="tick">4</span>
                <span class="tick">5</span>
                <span class="tick">6<span class="tick-price">5&nbsp;400&nbsp;<span>₽</span></span></span>
                <span class="tick">7</span>
                <span class="tick">8</span>
                <span class="tick">9</span>
                <span class="tick">10</span>
                <span class="tick">11</span>
                <span class="tick">12<span class="tick-price">10&nbsp;800&nbsp;<span>₽</span></span></span>
            </div>
            <input type="range" min="1" max="12" value="1">
            <span id="slider-label" class="slider-label">1&nbsp;000</span>
        </div>
        <div class="row_div modes">
            <span class="bkt-bg-yellow mode">Платный</span>
            <span class="bkt-bg-blue mode">Бесплатный</span>
        </div>
        <div class="col_div tariffes">
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Анализ автотранспорта</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <label data-v-90aed0a4="" class="bkt-check__input-check"></label>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Анализ объектов недвижимости</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Анализ дебиторской задолженности</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Документы и фотографии, полученные от организатора торгов</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Готовые шаблоны запросов для организатора торгов</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Отправка запросы организатору торгов в 1 клик</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Создание заявки на участие в торгах</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Планировщик задач - личный ежедневник для эффективного управления своей
                            деятельностью</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Напоминания по важным событиям / лотам/ задачам</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Готовый перечень необходимых документов для работы с лотами</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Рыночная стоимость объекта</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Командная работа с лотами</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Обмен документами и фотографиями между участниками команды</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Возможность ставить задачи участникам команды и контролировать их исполнение</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Планировщик</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <div data-v-90aed0a4="" class="bkt-check__input"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <span>Поиск выигранных лотов</span>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
                <div data-v-90aed0a4="" class="bkt-check__input mark"><input data-v-90aed0a4="" type="checkbox">
                    <div data-v-90aed0a4="" class="bkt-check__input-check"></div>
                </div>
            </div>
            <div class="row_div tariff">
                <button class="bkt-button bkt-bg-primary choose">Выбрать</button>
                <button class="bkt-button bkt-bg-primary choose">Выбрать</button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Tariffes"
    }
</script>

<style scoped>

</style>
