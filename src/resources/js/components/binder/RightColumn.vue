<template>
    <LabelContainer
        @remove-label-click="removeLabel"
        @drag-label-end="saveLabelOrder"
        :labels="labels"
    />
</template>
<script>
import LabelContainer from "../common/LabelContainer.vue";
export default {
    components: {
        LabelContainer
    },
    computed: {
        labels: {
            set(val) {
                this.$store.commit("binder/setLabels", val);
            },
            get() {
                return this.$store.state.binder.labels;
            }
        }
    },
    methods: {
        /**
         * ラベルをDBから削除します。
         */
        removeLabel(label) {
            this.$store.dispatch("binder/removeLabel", label);
        },
        /**
         * ラベルの並び順を永続化します。
         */
        saveLabelOrder(labels) {
            // NOTE: set()が呼びだされる
            this.labels = labels;
        }
    }
};
</script>
