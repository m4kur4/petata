<template>
    <form @submit.prevent="register" class="form--signup">
        <FormTitle>Sign up</FormTitle>
        <div class="form__wrapper--signup">

            <TextForm 
                v-model="form.name"
                :title="'User name*'"
                :type="'text'"
                :placeholder="'ぺったん太郎'"
            />
            <TextForm 
                v-model="form.email"
                :title="'Email*'"
                :type="'text'"
                :placeholder="'taro-1234@petata.com'"
            />
            <TextForm 
                v-model="form.password"
                :title="'Password*'"
                :type="'password'"
                :placeholder="'半角英数字8文字以上'"
            />
            <TextForm 
                v-model="form.password_confirmation"
                :title="'Password (Confirm)*'"
                :type="'password'"
                :placeholder="''"
            />

            <button type="submit" class="form__button--submit">Sign up</button>
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
                password_confirmation: ""
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
