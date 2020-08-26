<template>
    <div class="image-list--show mdc-elevation--z4">
        <div class="image-list__search mdc-elevation--z2">
            <input
                class="image-list__search-form"
                type="text"
                placeholder="Search"
            />
        </div>
        <div class="image-list__content">
            <ImageListItem
                :imageSource="'../_static/image/dummy.jpg'"
                :fileName="'ファイル名'"
            />
            <ImageListItem
                :imageSource="'../_static/image/dummy.jpg'"
                :fileName="'ファイル名'"
            />
            <ImageListItem
                :imageSource="'../_static/image/dummy.jpg'"
                :fileName="'ファイル名'"
            />
            <ImageListItem
                :imageSource="'../_static/image/dummy.jpg'"
                :fileName="'ファイル名'"
            />
            <ImageListItem
                :imageSource="'../_static/image/dummy.jpg'"
                :fileName="'ファイル名'"
            />
        </div>
        <!-- image-list__content -->
    </div>
    <!-- /.image-list--show -->
</template>

<script>
import ImageListItem from "./ImageListItem.vue";
export default {
    components: {
        ImageListItem
    }
};
</script>
