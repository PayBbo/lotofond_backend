<template>
    <bkt-modal :id="'messagePageModal'" :title="''" modal_class="bkt-filters-modal" no_footer
    >
        <template #body>
            <div class="bkt-page mx-0">
<!--                <iframe width="100%" height="500px" frameborder="0" ref="test"-->
<!--                        allowtransparency="true" :src="url" allow-same-origin allowfullscreen-->

<!--                >-->
<!--                    &lt;!&ndash;                scrolling="no"&ndash;&gt;-->
<!--                </iframe>-->
<!--                <div v-html="page" id="shadow"></div>-->
            </div>
<!--            <show-hello name="John"></show-hello>-->
<!--            <embedded-webview-->
<!--               src="https://old.bankrot.fedresurs.ru/MessageWindow.aspx?ID=8E17E5C3280645A955641C6C7BB72B2E"-->
<!--            ></embedded-webview>-->
        </template>
    </bkt-modal>
</template>

<script>
    // customElements.define('embedded-webview', class extends HTMLElement {
    //     connectedCallback() {
    //         fetch(this.getAttribute('src'))
    //             .then(response => response.html())
    //             .then(html => {
    //                 const shadow = this.attachShadow({ mode: 'closed' });
    //                 shadow.innerHTML = html;
    //             });
    //     }
    // });

    export default {
        name: "MessagePageModal",
        // props:['url'],
        data() {
            return {
                url: '',
                page: ''
            }
        },
        mounted() {

        },
        methods: {
            setUrl(value) {
                this.url = value;
            }
        }
    }
</script>

<style scoped>

</style>
