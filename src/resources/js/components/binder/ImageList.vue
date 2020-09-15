<template>
    <div class="image-list mdc-elevation--z4">
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
            class="image-list__wrapper"
        >
            <transition-group class="image-list__content" tag="div" name="fade">
                <ImageListItem
                    v-for="(image, index) in images"
                    @show-lightbox-click="showLightBox"
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
        },
        /**
         * ライトボックスで画像を表示します。
         * NOTE: 親コンポーネント経由でLightBoxコンポーネントのメソッドを呼びだす
         */
        showLightBox(imageIndex) {
            this.$emit("show-lightbox-click", imageIndex);
        }
    }
};
</script>
