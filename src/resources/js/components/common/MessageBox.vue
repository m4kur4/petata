<template>
    <transition name="fade">
        <div v-if="haeMessage" class="message-box__wrapper mdc-elevation--z4">
            <div @click="close" class="message-box__close">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="24"
                    viewBox="0 0 24 24"
                    width="24"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"
                    />
                </svg>
            </div>
            <transition-group name="fade">
                <div
                    v-for="message in messages"
                    :key="message.count"
                    class="message-box__item"
                >
                    <span class="message-box__icon">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="16"
                            viewBox="0 0 24 24"
                            width="16"
                        >
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"
                            />
                        </svg>
                    </span>
                    <span class="message-box__text">{{ message.val }}</span>
                </div>
            </transition-group>
        </div>
    </transition>
</template>

<script>
export default {
    prop: {
        errors: {
            type: Object,
            default: {}
        }
    },
    computed: {
        haeMessage() {
            return this.messages.length > 0;
        },
        messages() {
            return this.$store.state.messageBox.messages;
        }
    },
    methods: {
        /**
         * メッセージを閉じます
         */
        close() {
            this.$store.dispatch("messageBox/clear");
        }
    }
};
</script>
