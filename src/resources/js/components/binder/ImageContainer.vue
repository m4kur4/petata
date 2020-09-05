<template>
    <Draggable
        @end="resetDraggable"
        v-model="images"
        :options="draggableOptions"
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
        }
    }
};
</script>
