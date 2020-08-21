<template>
    <div @click="closeDialog" v-if="isShowDialog" class="modal-background"></div>
</template>
<script>
export default {
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
    },
    methods: {
        closeDialog() {
            this.$store.commit('mode/setIsShowDialog', false)
        }
    }
}
</script>