<template>
    <div id="image-container" class="image-container">
        <ImageContainerThumbnail
            v-for="image in images"
            :key="image.id"
            :imageSource="image.storage_file_path"
            :fileName="image.name"
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
};
</script>
