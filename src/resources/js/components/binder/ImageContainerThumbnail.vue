<template>
    <div
        @dragstart="dragStart($event)"
        @drag="drag($event)"
        class="image-container__thumbnail"
    >
        <img
            class="image-container__thumbnail-image mdc-elevation--z2"
            ref="thumbnailImage"
            :image-id="id"
            :id="`image-${id}`"
            :src="imageSource"
            :alt="fileName"
        />
    </div>
</template>
<script>
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
            event.dataTransfer.setData('image-id', this.id);
            console.log(this.id);
        },
        drag(event) {
            console.log('移動中');
        }
    }
};
</script>
