<template>
    <header class="header mdc-elevation--z2">
        <div class="header__wrapper">
            <div class="header__logo">
                <img
                    class="header__logo-image"
                    src="/image/logo/logo_48_white.svg"
                    width="42"
                    height="42"
                    alt="petata"
                />
                <h1 class="header__logo-title">
                    PETATA!
                </h1>
            </div>
            <div class="user-info__wrapper">
                <div
                    v-if="isLoggedIn"
                    @click="switchUserMenu"
                    :class="['user-info', { open: isOpenUserMenu }]"
                >
                    {{ userName }}
                </div>
                <transition name="fade-middle">
                    <div
                        @click.self="closeUserMenu"
                        v-show="isOpenUserMenu"
                        :class="['user-menu__wrapper']"
                    >
                        <div @click="logout" class="user-menu">
                            サインアウト
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </header>
</template>
<script>
export default {
    data() {
        return {
            isOpenUserMenu: false
        };
    },
    methods: {
        switchUserMenu() {
            this.isOpenUserMenu = !this.isOpenUserMenu;
        },
        closeUserMenu() {
            this.isOpenUserMenu = false;
        },
        async logout() {
            this.closeUserMenu();
            await this.$store.dispatch("auth/logout");

            // サインイン画面へ遷移
            this.$router.push({ name: "signin" });
        }
    },
    computed: {
        isLoggedIn() {
            return this.$store.getters["auth/check"];
        },
        userName() {
            return this.$store.getters["auth/username"];
        }
    }
};
</script>
