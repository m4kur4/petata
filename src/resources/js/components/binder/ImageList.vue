<template>
    <div class="image-list--show mdc-elevation--z4">
        <div class="image-list__search mdc-elevation--z2">
            <input
                @keydown.enter="searchBinderImage"
                @blur="searchBinderImage"
                v-model="searchCondigionImageName"
                class="image-list__search-form"
                type="text"
                placeholder="Search"
            />
        </div>
        <Draggable
            v-model="images"
            :options="draggableOptions"
            class="image-list__content"
        >
            <ImageListItem
                v-for="(image, index) in images"
                :key="image.id"
                :index="index"
                :id="image.id"
                :imageSource="image.storage_file_path"
                :fileName="image.name"
            />
        </Draggable>
        <!-- image-list__content -->
    </div>
    <!-- /.image-list--show -->
</template>

<script>
import ImageListItem from "./ImageListItem.vue";
import Draggable from "vuedraggable";
export default {
    components: {
        ImageListItem,
        Draggable
    },
    data() {
        return {
            draggableOptions: {
                animation: 150,
                handle: ".image-list__item-thumbnail-image",
            }
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
        searchCondigionImageName: {
            get() {
                return this.$store.state.binder.search_condition.image_name;
            },
            set(val) {
                this.$store.commit("binder/setSearchConditionImageName", val);
            },
        },
    },
    methods: {
        /**
         * バインダー画像の検索APIを呼び出します。
         */
        searchBinderImage() {
            this.$store.dispatch("binder/searchBinderImage");
        },
    }
};
</script>
