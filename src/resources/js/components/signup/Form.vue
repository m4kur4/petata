<template>
    <form @submit.prevent="register" class="form--signup">
        <FormTitle>Sign up</FormTitle>
        <div class="form__wrapper--signup">

            <TextForm 
                :title="'User name*'"
                :bind_target="form.name"
                :type="'text'"
                :placeholder="'ぺったん太郎'"
            />
            <TextForm 
                :title="'Email*'"
                :bind_target="form.email"
                :type="'text'"
                :placeholder="'taro-1234@petata.com'"
            />
            <TextForm 
                :title="'Password*'"
                :bind_target="form.password"
                :type="'password'"
                :placeholder="'半角英数字8文字以上'"
            />
            <TextForm 
                :title="'Password (Confirm)*'"
                :bind_target="form.password_confirm"
                :type="'password'"
                :placeholder="''"
            />

            <button type="button" class="form__button--submit">Sign up</button>
        </div>
        <a href="#" class="form__link">Sign in</a>
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
                password_confirm: ""
            }
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
                // DEBUG:
                alert("成功しました。");
            }
        }
    }
};
</script>
