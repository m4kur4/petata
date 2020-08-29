<template>
    <div v-if="isLoading" class="loader"></div>
</template>

<script>
export default {
    computed: {
        isLoading() {
            return this.$store.state.mode.isLoading;
        }
    },
};
</script>