<template>
    <LabelContainer @remove-label-click="removeLabel" :labels="labels" />
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
    },
    methods: {
        removeLabel(label) {
            this.$store.dispatch("binder/removeLabel", label);
        }
    }
};
</script>
