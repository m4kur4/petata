<template>
    <main>
        <Header />
        <Navbar />
        <RouterView  />
        <ModalBackground />
    </main>
</template>

<script>
import Header from './components/common/Header.vue';
import Navbar from './components/common/Navbar.vue';
import ModalBackground from './components/common/ModalBackground.vue'

export default {
    components: {
        Navbar,
        Header,
        ModalBackground
    }
};
</script>