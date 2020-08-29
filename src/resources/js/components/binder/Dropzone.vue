<template>
    <VueDropzone
        :options="dropzoneOptions"
        ref="myVueDropzone"
        id="dropzone"
        :class="{
            'dropzone--show': isShow,
            'dropzone--hide': !isShow,
        }"
    >
    </VueDropzone>
    <!-- /.image-container -->
</template>

<script>
import vue2Dropzone from "vue2-dropzone";

import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
export default {
    components: {
        VueDropzone: vue2Dropzone,
        ImageContainerThumbnail
    },
    data: function() {
        const self = this;
        return {
            dropzoneOptions: {
                url: "hogehoge",
                thumbnailWidth: 150,
                maxFilesize: 0.5,
                headers: { "My-Awesome-Header": "header value" },
                paramName: "image", // name属性として扱われる
                maxFilesize: 2, //MB このサイズを超えるとerrorイベントが発火
                clickable: false, // クリックでファイル保存ダイアログを表示しない
                processing: function(file, response) {
                    // プレビューを削除する
                    file.previewElement.outerHTML = "";
                    // Dropzoneを非表示にする
                    self.hideDropzone();
                },
                complete: function(file, response) {},
                dragleave: function(file, response) {
                    // Dropzoneを非表示にする
                    self.hideDropzone();
                },
                dragend: function(file, response) {
                    self.hideDropzone();
                }, 
                drop: function(file, response) {
                    self.hideDropzone();
                }
            }
        };
    },
    methods: {
        hideDropzone() {
            this.$store.commit("mode/setIsShowDropzone", false);
        },
    },
    computed: {
        // NOTE: 処理完了前に非表示とすると処理が中断されるため、z-indexで表示を制御する
        isShow() {
            return this.$store.state.mode.isShowDropzone;
        }
    }
};
</script>
