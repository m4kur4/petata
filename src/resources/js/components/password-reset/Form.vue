<template>
    <form @submit.prevent="reset" class="form--signup">
        <FormTitle>
            <template v-slot:title>Reset Password</template>
        </FormTitle>
        <div class="form__wrapper--signup">
            <TextForm
                v-model="form.email"
                :title="'確認のため、メールアドレスを入力してください。'"
                :type="'text'"
                :placeholder="'peta-1234@petata.com'"
                :value="''"
                :errors="errors.email"
            />
            <TextForm
                v-model="form.password"
                :title="'Password*'"
                :type="'password'"
                :placeholder="'半角英数字8文字以上'"
                :value="''"
                :errors="errors.password"
            />
            <TextForm
                v-model="form.password_confirmation"
                :title="'Password (Confirm)*'"
                :type="'password'"
                :placeholder="''"
                :value="''"
            />
            <button type="submit" class="form__button--submit">Reset</button>
        </div>
    </form>
</template>
<script>
import FormTitle from "../common/FormTitle.vue";
import TextForm from "../common/TextForm.vue";

export default {
    components: {
        FormTitle,
        TextForm
    },
    data() {
        return {
            form: {
                email: "",
                password: "",
                password_confirmation: "",
                token: "",
            },
        };
    },
    methods: {
        /**
         * パスワードリセット
         */
        async reset() {
            await this.$store.dispatch("auth/resetPassword", this.form);
            const isSuccess = this.apiStatus;
            if (isSuccess) {
                
                // TODO: バインダー一覧へ遷移
                this.$router.push({ name: "binder-list" });
            }
        }
    },
    computed: {
        /**
         * APIの実行状態
         */
        apiStatus() {
            return this.$store.state.auth.apiStatus;
        },
        /**
         * エラーメッセージ
         */
        errors() {
            return this.$store.state.error.messages;
        }
    },
    mounted() {
        // トークンの設定
        this.form.token = this.$route.query.token;
    },
};
</script>
