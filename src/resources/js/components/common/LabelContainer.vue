<template>
    <div class="label-container">
        <LabelItem
            @remove-label-click="removeLabel"
            v-for="(label, index) in labels"
            :index="index"
            :key="index"
            :id="label.id"
            :name="label.name"
            :description="label.description"
        />
    </div>
    <!-- /.label-container -->
</template>

<script>
import LabelItem from "./LabelItem";
export default {
    components: {
        LabelItem
    },
    props: {
        labels: Array
    },
    methods: {
        /**
         * ラベルから発火されたラベル削除イベントを親へ委譲します。
         * カスタムイベント名："remove-label-click"
         */
        removeLabel(label) {
            this.$emit("remove-label-click", label);
        }
    }
};
</script>
