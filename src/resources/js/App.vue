<template>
    <main>
        <Header />
        <transition :name="getTransitionName()" mode="out-in">
            <Navbar />
        </transition>
        <transition :name="getTransitionName()" mode="out-in">
            <RouterView />
        </transition>
        <transition name="fade-faster">
            <ModalBackground />
        </transition>
        <Loader />
    </main>
</template>

<script>
import Header from "./components/common/Header.vue";
import Navbar from "./components/common/Navbar.vue";
import ModalBackground from "./components/common/ModalBackground.vue";
import Loader from "./components/common/Loader.vue";

export default {
    components: {
        Navbar,
        Header,
        ModalBackground,
        Loader
    },
    methods: {
        /**
         * ページ遷移のトランジションを制御します。
         * 画面操作に応じてトランジションのスタイルを動的に切り替えます。
         */
        getTransitionName() {
            return this.$store.state.mode.isInnerPage;
        }
    }
};
</script>
