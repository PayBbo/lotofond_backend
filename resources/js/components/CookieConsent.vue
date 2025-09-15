<template>
    <div v-if="!accepted" class="cookie-banner">
        <p>
            Мы используем cookie-файлы для улучшения работы сайта и показа релевантных лотов.
            <a href="/privacy-policy" target="_blank" rel="noopener noreferrer">Узнать больше</a>
        </p>
        <button @click="acceptCookies">Принять</button>
    </div>
</template>

<script>
    // import Cookies from 'js-cookie';

    export default {
        name: 'CookieConsent',
        data() {
            return {
                accepted: false,
            };
        },
        mounted() {
            // this.accepted = !!Cookies.get('cookies_accepted');
            this.accepted = localStorage.getItem('cookies_accepted');
        },
        methods: {
            acceptCookies() {
                localStorage.setItem('cookies_accepted', 'true');
                // Cookies.set('cookies_accepted', 'true', { expires: 365 });
                this.accepted = true;
            },
        },
    };
</script>

<style scoped>
    .cookie-banner {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: #2d2d2d;
        color: #fff;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
        font-size: 14px;
        box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.2);
    }

    .cookie-banner p {
        margin: 0;
        flex: 1;
    }

    .cookie-banner a {
        color: #29b1ff;
        text-decoration: underline;
    }

    .cookie-banner button {
        background: #29b1ff;
        border: none;
        color: white;
        padding: 8px 14px;
        cursor: pointer;
        border-radius: 10px;
        margin-left: 20px;
    }
</style>
