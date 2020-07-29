<template>
    <div>
        <Header />
        <main>
            <ProgressIndicator />
            <div  class="container">
                <RouterView  />
            </div>
        </main>
    </div>
</template>

<script>
import Header from './components/Header.vue';
import ProgressIndicator from './components/ProgressIndicator.vue';

export default {
    components: {
        Header,
        ProgressIndicator
    }
};


</script>