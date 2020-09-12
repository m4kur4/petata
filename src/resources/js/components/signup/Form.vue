<template>
    <form @submit.prevent="register" class="form--signup">
        <FormTitle>
            <template v-slot:title>Sign up</template>
        </FormTitle>
        <div class="form__wrapper--signup">
            <TextForm
                v-model="form.name"
                :title="'User name*'"
                :type="'text'"
                :placeholder="'ぺったん太郎'"
                :value="''"
                :errors="errors.name"
            />
            <TextForm
                v-model="form.email"
                :title="'Email*'"
                :type="'text'"
                :placeholder="'taro-1234@petata.com'"
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

            <button type="submit" class="form__button--submit">Sign up</button>
        </div>
        <RouterLink :to="{ name: 'signin' }" class="form__link"
            >Sign in</RouterLink
        >
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
                name: "",
                email: "",
                password: "",
                password_confirmation: ""
            },
        };
    },
    methods: {
        /**
         * ユーザー登録
         */
        async register() {
            await this.$store.dispatch("auth/register", this.form);
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
    }
};
</script>
