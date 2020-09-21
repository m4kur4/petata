<template>
    <transition name="fade">
        <div class="remind-password-popover__content">
            <div class="remind-password-popover__header mdc-elevation--z1">
                <span class="remind-password-popover__header-text">
                    Confirm
                </span>
            </div>
            <div class="remind-password-popover__content">
                <span class="remind-password-popover__description"
                    >パスワード再設定用のリンクを送るメールアドレスを入力してください。</span
                >
                <input
                    @keyup="checkIsSetEmail"
                    v-model="email"
                    ref="emailTextForm"
                    class="remind-password-popover__textform"
                    type="text"
                    placeholder="peta-1234@petata.com"
                />
                <div class="remind-password-popover__button-wrapper">
                    <button
                        @click="sendPasswordReminderMail"
                        :class="[
                            'remind-password-popover__button-ok',
                            {
                                disabled: !isSetEmail
                            }
                        ]"
                        v-close-popover
                        type="button"
                    >
                        Send
                    </button>
                    <button
                        v-close-popover
                        class="remind-password-popover__button-no"
                        type="button"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            isSetEmail: false,
            email: "",
        };
    },
    methods: {
        /**
         * メールアドレスがテキストフォームに設定されているかどうかを判定します。
         */
        checkIsSetEmail() {
            const input = this.$refs.emailTextForm.value;
            const reg = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]{1,}\.[A-Za-z0-9]{1,}$/;
            this.isSetEmail = reg.test(input);
        },
        /**
         * リマインダーメールを送信します。
         */
        sendPasswordReminderMail() {
            if (!this.isSetEmail) {
                return false;
            }
            
            this.$store.dispatch("auth/sendPasswordReminderMail", this.email);

            this.isSetEmail = false;
            this.email = "";
        },
    }
};
</script>
