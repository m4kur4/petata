<template>
    <form @submit.prevent="register" class="form--signup">
        <div class="form__title">
            <h2>
                <img
                    src="image/logo_32.svg"
                    width="48"
                    height="48"
                    alt="petata"
                />
                Sign up
            </h2>
        </div>
        <div class="form__wrapper--signup">
            <label class="form__label">User name*</label>
            <input
                v-model="form.name"
                type="text"
                class="form__text"
                placeholder="ぺったん太郎"
            />
            <label class="form__label"
                >Email*
                <span class="form__error-message"
                    >メールアドレスの形式が正しくありません。</span
                >
            </label>
            <input
                v-model="form.email"
                type="text"
                class="form__text"
                placeholder="taro-2525@petata.com"
            />
            <label class="form__label">Password*</label>
            <input
                v-model="form.password"
                type="password"
                class="form__text"
                placeholder="8文字以上 半角英数字"
            />
            <label class="form__label"
                >Password (Confirm)*
                <span class="form__error-message"
                    >パスワードが一致しません。</span
                >
            </label>
            <input v-model="form.password" type="password" class="form__text" />
            <button type="button" class="form__button--submit">Sign up</button>
        </div>
        <a href="#" class="form__link">Sign in</a>
    </form>
</template>
<script>
export default {
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
