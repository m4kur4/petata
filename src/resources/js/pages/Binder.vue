<template>
    <div class="container--binder">
        <ImageList @show-lightbox-click="showLightBox" />
        <ImageContainer @show-lightbox-click="showLightBox" />
        <RightColumn />
        <LightBox ref="lightBox" />
        <Dropzone />
    </div>
</template>

<script>
require("vue-image-lightbox/dist/vue-image-lightbox.min.css");
import { STATUS, MESSAGE, MESSAGE_TYPE } from "../const";
import { util } from "../util";
import ImageList from "../components/binder/ImageList.vue";
import ImageContainer from "../components/binder/ImageContainer.vue";
import RightColumn from "../components/binder/RightColumn.vue";
import LightBox from "../components/binder/LightBox.vue";
import Dropzone from "../components/binder/Dropzone.vue";
export default {
    components: {
        ImageList,
        ImageContainer,
        RightColumn,
        LightBox,
        Dropzone
    },
    computed: {
        isLoading() {
            return this.$store.state.mode.isLoading;
        }
    },
    methods: {
        showDropzone() {
            this.$store.commit("mode/setIsShowDropzone", true);
        },
        hideDropzone() {
            this.$store.commit("mode/setIsShowDropzone", false);
        },
        /**
         * ドロップゾーンの表示制御をDOMへバインドします。
         */
        initializeDropzone() {
            // D&D禁止領域の指定
            window.addEventListener(
                "dragover",
                function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                },
                false
            );
            window.addEventListener(
                "drop",
                function(ev) {
                    ev.preventDefault();
                    ev.stopPropagation();
                },
                false
            );

            // NOTE: クロージャの中からコンポーネントのメソッドを呼びだす
            const self = this;
            const imageContainer = document.getElementById("image-container");

            imageContainer.ondragover = function(ev) {
                const isFileDragOver = ev.dataTransfer.types[0] == "Files";

                // バインダー画像のドラッグには反応させない
                if (!isFileDragOver) {
                    return;
                }

                ev.preventDefault();
                ev.stopPropagation();
                self.showDropzone();
                console.log("おけまる");
            };
        },
        /**
         * ライトボックスで画像を表示します。
         * NOTE: ImageContainerThumbnailからキックする
         */
        showLightBox(imageIndex) {
            this.$refs.lightBox.showLightBox(imageIndex);
        }
    },
    async beforeCreate() {
        // ナビゲーションバーを表示する
        this.$store.commit("mode/setHasNavigation", true);
        // バインダー情報を取得する。
        await this.$store.dispatch("binder/fetchBinder", this.$route.params.id);

        if (this.$store.state.error.code == STATUS.NOT_FOUND) {
            // アクセスできないバインダーを指定した場合はエラー
            const message = util.createMessage(
                MESSAGE.BINDER.NOT_FOUND,
                MESSAGE_TYPE.ERROR
            );
            this.$store.dispatch("messageBox/add", message);
            // バインダー一覧へリダイレクト
            this.$router.push({ name: "binder-list" });
        }
    },
    mounted() {
        // 画像コンテナへドラッグオーバーしている間だけDropzoneが表示されるようにする
        this.initializeDropzone();
    },
    destroyed() {
        // バインダー情報をクリアする
        this.$store.dispatch("binder/clearBinder");
    }
};
</script>
