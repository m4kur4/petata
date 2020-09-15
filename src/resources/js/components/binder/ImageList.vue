<template>
    <div class="image-list mdc-elevation--z4">
        <div class="image-list__search mdc-elevation--z2">
            <div class="image-list__search-wrapper">
                <button
                    @click="searchBinderImage"
                    type="button"
                    class="image-list__search-button"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="30px"
                        height="30px"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                        />
                    </svg>
                </button>
                <input
                    @keydown.enter="searchBinderImage"
                    v-model="searchCondigionImageName"
                    class="image-list__search-input"
                    type="text"
                    placeholder="Search"
                />
            </div>
            <!-- /.form__tab-search-button -->
        </div>
        <!-- /.form__tab-search-wrapper -->
        <Draggable
            @start="startDraggable"
            @end="endDraggable"
            v-model="images"
            :options="draggableOptions"
            class="image-list__wrapper"
        >
            <transition-group class="image-list__content" tag="div" name="fade">
                <ImageListItem
                    v-for="(image, index) in images"
                    :key="image.id"
                    :index="index"
                    :id="image.id"
                    :imageSource="image.storage_file_path"
                    :fileName="image.name"
                />
            </transition-group>
        </Draggable>
        <!-- image-list__content -->
    </div>
    <!-- /.image-list--show -->
</template>

<script>
import ImageListItem from "./ImageListItem.vue";
import Draggable from "vuedraggable";
import { SAVE_ORDER_TYPE } from "../../const";
export default {
    components: {
        ImageListItem,
        Draggable
    },
    data() {
        return {
            orgImageIndex: null,
            draggableOptions: {
                animation: 150,
                handle: ".image-list__item-thumbnail-image",
                scrollSensitivity: 20
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
        async endDraggable(event) {
            // 並び順の永続化
            const imageId = event.item.getAttribute("image-id");
            const param = {
                target_id: imageId,
                org_index: this.orgImageIndex,
                save_order_type: SAVE_ORDER_TYPE.IMAGE
            };

            const postData = this.$store.getters[
                "binder/getDataForSaveOrderState"
            ](param);

            if (!!postData) {
                // ドラッグによって位置を変更した場合のみ永続化
                await this.$store.dispatch(
                    "binder/saveImageOrderState",
                    postData
                );

                // 並び順の情報を更新するため、バインダー画像を再取得
                this.$store.dispatch("binder/searchBinderImage", false);
            }

            // 移動方向判定用の変数をクリア
            this.orgImageIndex = null;
        }
    }
};
</script>
