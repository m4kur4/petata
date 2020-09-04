<template>
    <LightBox ref="lightBox" :media="images">
    </LightBox>
</template>

<script>
import LightBox from "vue-image-lightbox";
require("vue-image-lightbox/dist/vue-image-lightbox.min.css");
export default {
    components: {
        LightBox
    },
    computed: {
        /**
         * $state.binder.imagesの情報をLightBox用に変換して返却します。
         * 
         *  thumb: 'http://example.com/thumb.jpg',
         *  src: 'http://example.com/image.jpg',
         */
        images() {
            const imagesState = this.$store.state.binder.images;
            // TODO: サムネイル用の画像を別途用意する？
            // TODO: サムネイルではなくメニューボタンをスロット経由で表示する？
            const converted = imagesState.map(image => {
                return {
                    thumb: image.storage_file_path,
                    src: image.storage_file_path
                };
            });
            console.log(converted);
            return converted;
        },
    },
    methods: {
        /**
         * ライトボックスで画像を表示します。
         * NOTE: ImageContainerThumbnailからキックする
         */
        showLightBox(imageIndex) {
            this.$refs.lightBox.showImage(imageIndex);
        },
    },
};
</script>
