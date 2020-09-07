<template>
    <Draggable v-model="computedLabels" class="label-container">
        <LabelItem
            @remove-label-click="removeLabel"
            v-for="(label, index) in labels"
            :index="index"
            :key="index"
            :id="label.id"
            :name="label.name"
            :description="label.description"
        />
    </Draggable>
    <!-- /.label-container -->
</template>

<script>
import LabelItem from "./LabelItem";
import Draggable from "vuedraggable";
export default {
    components: {
        LabelItem,
        Draggable
    },
    props: {
        labels: Array
    },
    computed: {
        computedLabels: {
            set(val) {
                // NOTE: 親画面毎にstoreが異なるため、stateの更新を委譲する
                this.$emit("drag-label-end", val);
            },
            get() {
                return this.labels;
            }
        }
    },
    methods: {
        /**
         * ラベルから発火されたラベル削除処理を親へ委譲します。
         * カスタムイベント名："remove-label-click"
         */
        removeLabel(label) {
            this.$emit("remove-label-click", label);
        },
    }
};
</script>
