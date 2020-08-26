<template>
    <div class="image-container">
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
    </div>
    <!-- /.image-container -->
</template>

<script>
import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
export default {
    components: {
        ImageContainerThumbnail
    }
};
</script>
