<template>
    <div id="binder-content" class="container--binder">
        <ImageList />
        <ImageContainer />
        <RightColumn />
        <Dropzone />
        <div class="loader"></div>
    </div>
</template>

<script>
import ImageList from "../components/binder/ImageList.vue";
import ImageContainer from "../components/binder/ImageContainer.vue";
import RightColumn from "../components/binder/RightColumn.vue";
import Dropzone from "../components/binder/Dropzone.vue";

export default {
    components: {
        ImageList,
        ImageContainer,
        RightColumn,
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
            // NOTE: クロージャの中からコンポーネントのメソッドを呼びだす
            const self = this;
            const imageContainer = document.getElementById("binder-content");

            imageContainer.ondragover = function(e) {
                self.showDropzone();
                console.log("おけまる");
            };
        }
    },
    beforeCreate() {
        // ナビゲーションバーを表示する
        this.$store.commit("mode/setHasNavigation", true);
    },
    mounted() {
        // 画像コンテナへドラッグオーバーしている間だけDropzoneが表示されるようにする
        this.initializeDropzone();
    }
};
</script>
