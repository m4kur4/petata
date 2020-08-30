<template>
    <LabelContainer :labels="labels" />
</template>
<script>
import LabelContainer from "../common/LabelContainer.vue";
export default {
    components: {
        LabelContainer
    },
    computed: {
        labels() {
            return this.$store.state.binder.labels;
        }
    }
};
</script>
