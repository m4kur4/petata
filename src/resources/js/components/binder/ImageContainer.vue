<template>
    <Draggable
        @start="startDraggable"
        @end="endDraggable"
        v-model="images"
        :options="draggableOptions"
        :force-fallback="true"
        id="image-container"
        class="image-container"
    >
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
        <Dropzone />
    </Draggable>
    <!-- /.image-container -->
</template>

<script>
import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
import Dropzone from "./Dropzone.vue";
import Draggable from "vuedraggable";
export default {
    components: {
        ImageContainerThumbnail,
        Dropzone,
        Draggable
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
            return {
                animation: 150,
                handle: ".thumbnail-inner-content__handle",
                scrollSensitivity: 200,
                forceFallback: true
            };
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
            this.$store.commit("binder/setIsDraggableProcessing", true);
        },
        /**
         * draggableによるソートの後処理を行います。
         */
        endDraggable(event) {
            // DOM要素の復元
            this.resetDraggable();

            // 並び順の永続化
            const imageId = event.item.getAttribute("image-id");

            const postData = this.$store.getters[
                "binder/getDataForSaveOrderState"
            ](imageId);

            this.$store.dispatch("binder/saveOrderState", postData);

            // 並び順の情報を更新するため、バインダー画像を再取得
            this.$store.dispatch("binder/searchBinderImage");
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
