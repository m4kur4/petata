<template>
    <form @submit.prevent="signin" class="form--signup">
        <FormTitle>
            <template v-slot:title>Sign in</template>
        </FormTitle>
        <div class="form__wrapper--signup">
            <TextForm
                v-model="form.email"
                :title="'Email'"
                :type="'text'"
                :placeholder="'peta-1234@petata.com'"
                :value="''"
                :errors="loginFailureError"
            />
            <TextForm
                v-model="form.password"
                :title="'Password'"
                :type="'password'"
                :placeholder="''"
                :value="''"
                :errors="[]"
            />
            <AutoSigninCheckbox />
            <button type="submit" class="form__button--submit">Sign in</button>
        </div>

        <!--
        <RouterLink :to="{ name: 'signup' }" class="form__link"
            >Sign up</RouterLink
        >
        -->
    </form>
</template>
<script>
import FormTitle from "../common/FormTitle.vue";
import TextForm from "../common/TextForm.vue";
import AutoSigninCheckbox from "./AutoSigninCheckbox.vue";
import GoogleSigninButton from "./GoogleSigninButton.vue";
import { util } from "../../util";
import { MESSAGE } from '../../const'; 

export default {
    components: {
        FormTitle,
        TextForm,
        AutoSigninCheckbox,
        GoogleSigninButton
    },
    data() {
        return {
            form: {
                email: "",
                password: ""
            }
        };
    },
    methods: {
        /**
         * ユーザー認証
         */
        async signin() {

            if (this.$store.state.auth.isEnabledAutoLogin) {
                // 継続ログインの有効化
                this.form.remember = true;
            }
            await this.$store.dispatch("auth/login", this.form);
            const isSuccess = this.apiStatus;
            if (isSuccess) {
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
        loginFailureError() {
            const errorResponses = this.$store.state.error.messages;
            // エラー内容に関わらずログイン失敗の通知を表示
            if (!util.isEmptyObject(errorResponses)) {
                return [MESSAGE.SIGNIN.NOTIFY];
            }
        }
    }
};
</script>
