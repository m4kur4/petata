<template>
    <Draggable
        @start="startDraggable"
        @end="endDraggable"
        v-model="images"
        :animation="150"
        :handle="`.thumbnail-inner-content__handle`"
        :scrollSensitivity="200"
        :forceFallback="true"
        :scrollSpeed="200"
        :fallback-tolerance="1"
        id="image-container"
        class="image-container__wrapper"
    >
        <transition-group class="image-container" tag="div" name="fade">
            <ImageContainerThumbnail
                v-for="(image, index) in images"
                @show-lightbox-click="showLightBox"
                :key="image.id"
                :index="index"
                :id="image.id"
                :imageSource="image.storage_file_path"
                :fileName="image.name"
                :labelingLabelIds="image.labeling_label_ids"
            />
        </transition-group>
    </Draggable>
    <!-- /.image-container -->
</template>

<script>
import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
import Draggable from "vuedraggable";
import { SAVE_ORDER_TYPE } from "../../const";
export default {
    components: {
        ImageContainerThumbnail,
        Draggable
    },
    data() {
        return {
            /**
             * ドラッグ中画像の移動前におけるインデックス
             * NOTE: Draggableで移動する要素の移動方向を判定するため
             */
            orgImageIndex: null
        };
    },
    computed: {
        images: {
            get() {
                return this.$store.state.binder.images;
            },
            set(val) {
                this.$store.commit("binder/setImages", val);
            }
        },
        draggableOptions() {
            // NOTE: 画像のスクロールがdataだと上手くいかないのでcomputedへ定義
            return {};
        }
    },
    methods: {
        /**
         * ライトボックスで画像を表示します。
         * NOTE: 親コンポーネント経由でLightBoxコンポーネントのメソッドを呼びだす
         */
        showLightBox(imageIndex) {
            this.$emit("show-lightbox-click", imageIndex);
        },
        /**
         * draggableによるソートの初期処理を行います。
         *
         * NOTE: バインダー画像のメニューボタンがドラッグに追従しない
         */
        startDraggable(event) {
            console.log("D0");
            console.log(event.item.getAttribute("image-id"));
            console.log("/D0");
            this.$store.commit("binder/setIsDraggableProcessing", true);
            // 移動前のインデックスを保持
            this.orgImageIndex = event.item.getAttribute("index");
        },
        /**
         * draggableによるソートの後処理を行います。
         */
        endDraggable(event) {
            console.log("D1");
            console.log(event.item.getAttribute("image-id"));
            console.log("/D1");

            // DOM要素の復元
            this.resetDraggable();

            // 並び順の永続化
            const imageId = event.item.getAttribute("image-id");
            const param = {
                target_id: imageId,
                org_index: this.orgImageIndex,
                save_order_type: SAVE_ORDER_TYPE.IMAGE
            };

            const postData = this.$store.getters[
                "binder/getDataForSaveOrderState"
            ](param);

            if (!!postData) {
                // ドラッグによって位置を変更した場合のみ永続化
                this.$store.dispatch("binder/saveImageOrderState", postData);

                // 並び順の情報を更新するため、バインダー画像を再取得
                this.$store.dispatch("binder/searchBinderImage", false);
            }

            // 移動方向判定用の変数をクリア
            this.orgImageIndex = null;
        },
        /**
         * バインダー画像のdraggable属性を復活させます。
         *
         * NOTE: Vue.Draggableのhandleオプションを使うと、
         * ドラッグ後に`draggable="false"`が設定されてしまう。
         */
        resetDraggable() {
            const images = document.getElementsByClassName(
                "image-container__thumbnail-image"
            );
            for (let i = 0; i < images.length; i++) {
                images[i].setAttribute("draggable", true);
            }

            this.$store.commit("binder/setIsDraggableProcessing", false);
        }
    }
};
</script>
