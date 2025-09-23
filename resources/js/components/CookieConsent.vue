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
        /*
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
         */
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 500px;
        padding: 20px 25px;
        border-radius: 16px;
        /*background: rgba(255, 255, 255, 0.2);*/
        background: rgb(245, 247, 254, 0.52);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        color: #2d3244;
        display: flex;
        justify-content: space-between;
        align-items: center;
        z-index: 1000;
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
        padding: 8px 14px;
        margin-left: 20px;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        cursor: pointer;
        transition: background 0.3s ease;

        background-color: rgba(41, 177, 255, 0.8);
        color: white;
        /*
        background: #29b1ff;
        border: none;
        color: white;
        padding: 8px 14px;
        cursor: pointer;
        border-radius: 10px;
        margin-left: 20px;
         */
    }
</style>
