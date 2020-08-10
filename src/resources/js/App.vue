<template>
    <div>
        <Header />
        <Navbar />
        <main>
            <div  class="container">
                <RouterView  />
            </div>
        </main>
    </div>
</template>

<script>
import Header from './components/Header.vue';
import Navbar from './components/Navbar.vue';
import ProgressIndicator from './components/ProgressIndicator.vue';

export default {
    components: {
        Header,
        Navbar,
        ProgressIndicator
    }
};
</script>