<template>
    <div id="image-container" class="image-container">
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
    </div>
    <!-- /.image-container -->
</template>

<script>
import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
import Dropzone from "./Dropzone.vue";
export default {
    components: {
        ImageContainerThumbnail,
        Dropzone
    },
    computed: {
        images() {
            return this.$store.state.binder.images;
        },
    },
    methods: {
        /**
         * ライトボックスで画像を表示します。
         * NOTE: 親コンポーネント経由でLightBoxコンポーネントのメソッドを呼びだす
         */    
        showLightBox(imageIndex) {
            this.$emit("show-lightbox-click", imageIndex);
        },
    }
};
</script>
