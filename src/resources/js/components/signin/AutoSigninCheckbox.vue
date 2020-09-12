<template>
    <span class="form__checkbox">
        <label for="chkRemember">
            <input
                @change="switchEnableAutoLogin"
                ref="chkRemember"
                id="chkRemember"
                type="checkbox"
            />Remember me
        </label>
        <!--
        <a href="#" class="form__link--right">Forget password</a>
        -->
    </span>
</template>
<script>
export default {
    computed: {
        /**
         * 継続ログインの有無を双方向バインドします。
         */
        isEnabledAutoLogin: {
            get() {
                return this.$store.state.auth.isEnabledAutoLogin;
            },
            set(val) {
                this.$store.commit("auth/setIsEnableAutoLogin", val);
            }
        }
    },
    methods: {
        /**
         * 継続ログインの有無を切り替えます。
         */
        switchEnableAutoLogin() {
            const isChecked = this.$refs.chkRemember.checked;
            if (isChecked) {
                this.isEnabledAutoLogin = true;
            } else {
                this.isEnabledAutoLogin = false;
            }
        }
    }
};
</script>
