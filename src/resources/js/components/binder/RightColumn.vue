<template>
    <LabelContainer
        ref="labelContainer"
        @remove-label-click="removeLabel"
        @label-state-change="updateLabelState"
        @drag-label-start="startDraggable"
        @drag-label-end="endDraggable"
        :labels="labels"
    />
</template>
<script>
import LabelContainer from "../common/LabelContainer.vue";
import { SAVE_ORDER_TYPE } from "../../const";
export default {
    components: {
        LabelContainer
    },
    data() {
        return {
            orgLabelIndex: null,
            draggableOptions: {
                animation: 150,
                handle: ".image-list__item-thumbnail-image",
                scrollSensitivity: 200,
                forceFallback: true
            }
        };
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
         * ラベルの状態をstateへ反映します。
         */
        updateLabelState(labels) {
            // NOTE: set()が呼びだされる
            this.labels = labels;
        },
        /**
         * draggableによるソートの初期処理を行います。
         */
        startDraggable(target) {
            // 移動前のインデックスを保持
            this.orgLabelIndex = target.index;
            console.log("[DEBUG]orgLabelIndex = " + this.orgLabelIndex);
        },
        /**
         * draggableによるソートの後処理を行います。
         */
        endDraggable(labelId) {
           
            // 並び順の永続化
            //const labelId = event.item.getAttribute("label-id");
            const param = {
                target_id: labelId,
                org_index: this.orgLabelIndex,
                save_order_type: SAVE_ORDER_TYPE.LABEL
            };

            const postData = this.$store.getters[
                "binder/getDataForSaveOrderState"
            ](param);

            //this.$store.dispatch("binder/saveLabelOrderState", postData);

            // 並び順の情報を更新するため、バインダー画像を再取得
            //this.$store.dispatch("binder/searchBinderImage");

            // 移動方向判定用の変数をクリア
            this.orgLabelIndex = null;
        }
    }
};
</script>
