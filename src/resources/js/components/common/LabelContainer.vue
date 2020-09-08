<template>
    <Draggable
        @start="startDraggable"
        @end="endDraggable"
        v-model="computedLabels"
        class="label-container__wrapper"
    >
        <transition-group class="label-container" tag="div" name="fade">
        <LabelItem
            @remove-label-click="removeLabel"
            v-for="(label, index) in labels"
            :index="index"
            :key="(label.id == 0) ? index : label.id"
            :id="label.id"
            :name="label.name"
            :description="label.description"
        />
        </transition-group>
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
    data() {
        return {
            // FIXME: イベントの対象が変わるので保持しようとしてもできない
            dragEvent: null,
            // FIXME: 暫定対応としてドラッグ開始時点のIDとインデックスを保持
            dragTargetId: null,
            dragTargetIndex: null,
        };
    },
    props: {
        labels: Array
    },
    computed: {
        /**
         * ラベルの状態をstateと双方向バインドします。
         * カスタムイベント名："label-state-change"
         */
        computedLabels: {
            set(val) {
                // NOTE: 親画面毎にstoreが異なるため、stateの更新を委譲する
                this.$emit("label-state-change", val);
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
        /**
         * draggableによるソートの初期処理を行います。
         *
         * NOTE: 親コンポーネントに委譲
         * カスタムイベント名："drag-label-start"
         */
        startDraggable(event) {

            // FIXME: 暫定対応でラベルIDとインデックスを保持
            this.dragTargetId = event.item.getAttribute("label-id");
            this.dragTargetIndex = event.item.getAttribute("index");

            // FIXME: @startと@endでevent.itemが違う
            this.dragEvent = event;
            console.log("D0");
            console.log(event.item.getAttribute("label-id"));
            console.log("/D0");

            console.log("D0-A");
            console.log(this.dragEvent.item.getAttribute("label-id"));
            console.log("/D0-A");

            console.log("D0-B");
            console.log(this.dragTargetId);
            console.log("D0-B");

            const target = {
                id: this.dragTargetId,
                index: this.dragTargetIndex
            };
            //this.$emit("drag-label-start", event);
            this.$emit("drag-label-start", target);
            
        },
        /**
         * draggableによるソートの後処理を行います。
         *
         * NOTE: 親コンポーネントに委譲
         * カスタムイベント名："drag-label-end"
         */
        endDraggable(event) {
            // FIXME: @startと@endでevent.itemが違う
            console.log("D1");
            console.log(event.item.getAttribute("label-id"));
            console.log("/D1");

            console.log("D1-A");
            console.log(this.dragEvent.item.getAttribute("label-id"));
            console.log("/D1-A");

            console.log("D1-B");
            console.log(this.dragTargetId);
            console.log("D1-B");

            //this.$emit("drag-label-end", event);
            this.$emit("drag-label-end", this.dragTargetId);
        }
    }
};
</script>
