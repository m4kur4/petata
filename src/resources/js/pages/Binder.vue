<template>
    <div class="container--binder">
        <ImageList />
        <ImageContainer @show-lightbox-click="showLightBox" />
        <RightColumn />
        <LightBox ref="lightBox" />
        <Loader />
    </div>
</template>

<script>
require("vue-image-lightbox/dist/vue-image-lightbox.min.css");
import ImageList from "../components/binder/ImageList.vue";
import ImageContainer from "../components/binder/ImageContainer.vue";
import RightColumn from "../components/binder/RightColumn.vue";
import LightBox from "../components/binder/LightBox.vue";
import Loader from "../components/common/Loader.vue";

export default {
    components: {
        ImageList,
        ImageContainer,
        RightColumn,
        LightBox,
        Loader
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
        },
    },
    beforeCreate() {
        // ナビゲーションバーを表示する
        this.$store.commit("mode/setHasNavigation", true);
        // バインダー情報を取得する。
        this.$store.dispatch("binder/fetchBinder", this.$route.params.id);
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
