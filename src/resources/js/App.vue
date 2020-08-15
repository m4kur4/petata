<template>
    <main>
        <Header />
        <Navbar />
        <RouterView  />
    </main>
</template>

<script>
import Header from './components/common/Header.vue';
import Navbar from './components/common/Navbar.vue';

export default {
    components: {
        Navbar,
        Header,
    }
};
</script>