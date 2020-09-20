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
        <v-popover
            class="form__link--right"
            :trigger="'click'"
            :popoverBaseClass="['remove-binder-popover', 'tooltip', 'popover']"
            :placement="'bottom-start'"
        >
            <a href="#">Forget password</a>
            <!-- 以下にコンポーネントなどをスロットできる -->
            <template slot="popover">
                <PasswortdRemindPopover />
            </template>
        </v-popover>
    </span>
</template>
<script>
import PasswortdRemindPopover from "./PasswortdRemindPopover.vue";
export default {
    components: {
        PasswortdRemindPopover
    },
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
