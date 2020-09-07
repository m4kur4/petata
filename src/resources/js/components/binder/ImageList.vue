<template>
    <div class="image-list--show mdc-elevation--z4">
        <div class="image-list__search mdc-elevation--z2">
            <input
                @keydown.enter="searchBinderImage"
                v-model="searchCondigionImageName"
                class="image-list__search-form"
                type="text"
                placeholder="Search"
            />
        </div>
        <Draggable
            @start="startDraggable"
            @end="endDraggable"
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
                handle: ".image-list__item-thumbnail-image"
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
            }
        }
    },
    methods: {
        /**
         * バインダー画像の検索APIを呼び出します。
         */
        searchBinderImage() {
            this.$store.dispatch("binder/searchBinderImage");
        },
        /**
         * draggableによるソートの初期処理を行います。
         */
        startDraggable(event) {
            // 移動前のインデックスを保持
            this.orgImageIndex = event.item.getAttribute("index");
        },
        /**
         * draggableによるソートの後処理を行います。
         */
        endDraggable(event) {
            // 
            console.log("びっくりドンキー");
            const imageId = event.item.getAttribute("image-id");
            const param = {
                image_id: imageId,
                org_index: this.orgImageIndex
            };

            const postData = this.$store.getters[
                "binder/getDataForSaveOrderState"
            ](param);

            this.$store.dispatch("binder/saveOrderState", postData);

            // 並び順の情報を更新するため、バインダー画像を再取得
            this.$store.dispatch("binder/searchBinderImage");

            // 移動方向判定用の変数をクリア
            this.orgImageIndex = null;
        }
    }
};
</script>
