<template>
    <div id="image-container" class="image-container">
        <ImageContainerThumbnail
            :imageSource="'../_static/image/dummy.jpg'"
            :fileName="'ファイル名'"
        />
        <ImageContainerThumbnail
            :imageSource="'../_static/image/dummy.jpg'"
            :fileName="'ファイル名'"
        />
        <ImageContainerThumbnail
            :imageSource="'../_static/image/dummy.jpg'"
            :fileName="'ファイル名'"
        />
        <ImageContainerThumbnail
            :imageSource="'../_static/image/dummy.jpg'"
            :fileName="'ファイル名'"
        />
        <ImageContainerThumbnail
            :imageSource="'../_static/image/dummy.jpg'"
            :fileName="'ファイル名'"
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
    }
};
</script>
