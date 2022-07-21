<template>
    <div class="container bkt-messages bkt-page bkt-container">
        <h1 class="bkt-page__title bkt-auctions__title">
            Сообщения
        </h1>

        <div class="bkt-content">
            <div class="row">
                <div class="col-12 col-lg-3">
                    <div class="bkt-history__chats">
                        <ul class="list-unstyled text-left pt-4 pb-4">
                            <li class="bkt-chat" :class="{'bkt-bg-primary-lighter': selectedCategory==0}" id="chat-1"
                                @click="selectedCategory = 0">
                                <span>Все</span>
                                <div class="rounded-pill bkt-bg-primary bkt-text-neutral-light">
                                    <span v-if="countMessages.all > 0" class="p-2">{{ countMessages.all }}</span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-green-lighter': selectedCategory==1}" id="chat-2"
                                @click="selectedCategory = 1">
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Bell'" :color="'green'" width="15px" height="15px" class="mr-2"/>
                                    <span>Сообщения платформы</span>
                                </div>

                                <div class="bkt-chat__num rounded-pill bkt-bg-green bkt-text-neutral-light">
                                    <span v-if="countMessages.platform > 0" class="p-2">{{
                                            countMessages.platform
                                        }}</span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-yellow-lighter': selectedCategory==2}" id="chat-3"
                                @click="selectedCategory = 2">
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Star'" :color="'yellow'" width="15px" height="15px" class="mr-2"/>
                                    <span>Избранное</span>
                                </div>
                                <div class="bkt-chat__num rounded-pill bkt-bg-yellow bkt-text-neutral-light">
                                    <span v-if="countMessages.favourites > 0" class="p-2">{{
                                            countMessages.favourites
                                        }}</span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-red-lighter': selectedCategory==3}" id="chat-4"
                                @click="selectedCategory = 3">
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Target'" :color="'red'" width="15px" height="15px" class="mr-2"/>
                                    <span>Мониторинг</span>
                                </div>

                                <div class="rounded-pill bkt-bg-red bkt-text-neutral-light">
                                    <span v-if="countMessages.monitoring > 0" class="p-2">{{
                                            countMessages.monitoring
                                        }}</span>
                                </div>
                            </li>
                            <li class="bkt-chat" :class="{'bkt-bg-purple-lighter': selectedCategory==4}" id="chat-5"
                                @click="selectedCategory = 4">
                                <div class="bkt-chat__text">
                                    <bkt-icon :name="'Chat'" :color="'purple'" width="15px" height="15px" class="mr-2"/>
                                    <span>От организаторов</span>
                                </div>

                                <div class="rounded-pill bkt-bg-purple bkt-text-neutral-light">
                                    <span v-if="countMessages.organization > 0"
                                          class="p-2">{{ countMessages.organization }}</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-9">
                    <div class="bkt-history__messages">
                        <div class="bkt-monitoring-checkboxes text-left mb-4" v-if="selectedCategory==3">
                            <bkt-checkbox :value="monitoring_filter.cars" label="АВТО" :name="'cars'"
                                          wrapper_class="bkt-check__wrapper-inline" class="mr-2"/>
                            <bkt-checkbox :value="monitoring_filter.flats" label="КВАРТИРЫ" :name="'flats'"
                                          wrapper_class="bkt-check__wrapper-inline"/>
                        </div>
                        <ul class="list-unstyled bkt-messages__block">
                            <li class="bkt-chat__item d-flex justify-content-between position-relative"
                                v-for="(message, index) in displayedMessages" :key="index" v-if="message">
                                <bkt-icon :name="'Check'" :color="message.read ? 'primary' : 'main-lighter'" width="15px"
                                          height="15px"
                                          class="mr-2 position-absolute bkt-icon-done"/>

                                <div class="d-md-none bkt-item-title d-flex mb-3 text-left">
                                    <span class="bkt-text-neutral-dark">{{ message.date }}</span>
                                    <div class="bkt-chat-content__info text-right">
                                        <p :class="'bkt-bg-'+message.category.color+'-lighter bkt-text-'+message.category.color ">
                                            {{ message.category.title }}
                                        </p>
                                    </div>
                                </div>

                                <div class="bkt-item-content text-left">
                                    <div class="bkt-content-message d-flex mb-3">
                                        <div class="bkt-chat-content__logo" v-if="message.img">
                                            <img src="" alt="" width="100%" height="100%">
                                        </div>

                                        <div class="bkt-chat-content__text">
                                            <p v-if="message.title" class="mb-0"
                                               :class="{'bkt-text-title bkt-arrow-after bkt-cursor-pointer' : !message.newLot}">
                                                {{ message.title }}
                                            </p>
                                            <p class="mb-0"
                                               :class="{'bkt-text-title bkt-arrow-after bkt-text-hidden bkt-cursor-pointer' : message.newLot}">
                                                {{ message.note }}</p>
                                        </div>
                                    </div>
                                    <button v-if="message.btnText" class="btn bkt-button p-4 primary mb-3">
                                        {{ message.btnText }}
                                    </button>
                                    <br class="d-none d-md-block">
                                    <span class="d-none d-md-block bkt-text-neutral-dark">{{ message.date }}</span>
                                </div>

                                <div class="d-none d-md-block bkt-chat-content__info text-right">
                                    <p :class="'bkt-bg-'+message.category.color+'-lighter bkt-text-'+message.category.color ">
                                        {{ message.category.title }}
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

export default {
    name: "Messages",
    components: {},
    data() {
        return {
            info_categories: [
                {id: 1, title: 'сообщения платформы', color: 'green'},
                {id: 2, title: 'избранное', color: 'yellow'},
                {id: 3, title: 'мониторинг', color: 'red'},
                {id: 4, title: 'организатор', color: 'purple'},
            ], monitoring_filter: {cars: true, flats: true},
            messages: [
                {
                    img: '',
                    note: 'Внимание! Обновление на сайте! Мы улучшили нашу работу, добавив возможность закрепить лот вверху списка.',
                    date: '14 марта 2022 в 15:31',
                    category: {id: 1, title: 'сообщения платформы', color: 'green'},
                    read: false
                },
                {
                    img: 'bmw',
                    title: 'БМВ Х5 (ЛОТ №50697876056078)',
                    note: 'Прием заявок заканчивается через 3 дня!',
                    date: '5 апреля 2022 в 20:00',
                    category: {id: 2, title: 'избранное', color: 'yellow'},
                    read: false
                },
                {
                    img: 'flat',
                    newLot: 'flat',
                    title: 'Новые лоты "Квартиры"',
                    note: 'ЛОТ №3456743, 3К КВАРТИРА ДОЛГОПРУДНЫЙ',
                    date: '12 апреля 2022 в 10:56',
                    category: {id: 3, title: 'мониторинг', color: 'red'},
                    read: true
                },
                {
                    img: 'bmw',
                    title: 'ИВАНОВ НИКОЛАЙ ДМИТРИЕВИЧ',
                    note: 'Здравствуйте, Сергей! Пока данных по лоту №83067 нет. Уточняю.',
                    date: '5 апреля 2022 в 20:00',
                    category: {id: 4, title: 'организатор', color: 'purple'},
                    read: true
                },
                {
                    img: '',
                    note: 'Сегодня последний день платной подписки. Пожалуйста, не забудьте продлить доступ!',
                    date: '14 марта 2022 в 15:31',
                    category: {id: 1, title: 'сообщения платформы', color: 'green'},
                    read: false,
                    btnText: 'Продлить подписку'
                },
            ],
            selectedCategory: 0, countMessages: {all: 0, platform: 0, favourites: 0, monitoring: 0, organization: 0}
        }
    },
    computed: {
        displayedMessages() {
            let sortMessages = this.messages.sort((a, b) => a.read - b.read);
            return sortMessages.filter(data => {
                return (
                    this.selectedCategory == 0 || data.category.id == this.selectedCategory
                );
            });
        }
    },
    mounted() {
        this.countMessages.all = this.messages.length;
        this.countMessages.platform = this.messages.filter(item => item.category.id == 1 && !item.read).length;
        this.countMessages.favourites = this.messages.filter(item => item.category.id == 2 && !item.read).length;
        this.countMessages.monitoring = this.messages.filter(item => item.category.id == 3 && !item.read).length;
        this.countMessages.organization = this.messages.filter(item => item.category.id == 4 && !item.read).length;
    }
}
</script>

<style scoped>

</style>
