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
                v-for="image in images"
                :key="image.id"
                :id="image.id"
                :imageSource="image.storage_file_path"
                :fileName="image.name"
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
    },
    computed: {
        images() {
            return this.$store.state.binder.images;
        },
    },
};
</script>
