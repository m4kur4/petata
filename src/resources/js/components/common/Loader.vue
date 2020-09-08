<template>
    <transition name="fade-faster">
        <div v-if="isLoading" class="loader"></div>
    </transition>
</template>

<script>
export default {
    computed: {
        isLoading() {
            return this.$store.state.mode.isLoading;
        }
    }
};
</script>
