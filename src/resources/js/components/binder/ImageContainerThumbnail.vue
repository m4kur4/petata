<template>
    <div
        @dragstart="dragStart($event)"
        @drag="drag($event)"
        class="image-container__thumbnail"
    >
        <div class="image-container__thumbnail-inner-content-wrapper">
            <img
                class="image-container__thumbnail-image mdc-elevation--z2"
                ref="thumbnailImage"
                :image-id="id"
                :id="`image-${id}`"
                :src="imageSource"
                :alt="fileName"
            />
            <div class="thumbnail-inner-content__button-wrapper">
                <button
                    @click="copyImage"
                    class="thumbnail-inner-content__button"
                >
                    <!-- クリップボードへコピー -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M2 12.5C2 9.46 4.46 7 7.5 7H18c2.21 0 4 1.79 4 4s-1.79 4-4 4H9.5C8.12 15 7 13.88 7 12.5S8.12 10 9.5 10H17v2H9.41c-.55 0-.55 1 0 1H18c1.1 0 2-.9 2-2s-.9-2-2-2H7.5C5.57 9 4 10.57 4 12.5S5.57 16 7.5 16H17v2H7.5C4.46 18 2 15.54 2 12.5z"
                        />
                    </svg>
                </button>
                <button class="thumbnail-inner-content__button">
                    <!-- クリップボードへコピー -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M2 12.5C2 9.46 4.46 7 7.5 7H18c2.21 0 4 1.79 4 4s-1.79 4-4 4H9.5C8.12 15 7 13.88 7 12.5S8.12 10 9.5 10H17v2H9.41c-.55 0-.55 1 0 1H18c1.1 0 2-.9 2-2s-.9-2-2-2H7.5C5.57 9 4 10.57 4 12.5S5.57 16 7.5 16H17v2H7.5C4.46 18 2 15.54 2 12.5z"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>
<script>
import { util } from "../../util";
export default {
    props: {
        id: Number,
        imageSource: String,
        fileName: String
    },
    methods: {
        /**
         * ラベリング実行のためのドラッグイベントです。
         * NOTE: ドロップ時、dataTransfer.getData('image-id')で画像のIDを取得
         */
        dragStart(event) {
            event.dataTransfer.setDragImage(this.$refs.thumbnailImage, 50, 50);
            event.dataTransfer.setData("image-id", this.id);
            console.log(this.id);
        },
        drag(event) {
            console.log("移動中");
        },
        /**
         * 画像をクリップボードにコピーします。
         */
        copyImage() {
            const image = this.$refs.thumbnailImage;
            util.copyImageToClipBoard(image);
        }
    }
};
</script>
