<template>
    <VueDropzone
        :options="dropzoneOptions"
        ref="myVueDropzone"
        id="dropzone"
        :class="{
            'dropzone--show': isShow,
            'dropzone--hide': !isShow
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
        const csrfToken = document.getElementById("csrf-token").content;
        return {
            dropzoneOptions: {
                url: "/api/binder/image/add",
                thumbnailWidth: 150,
                maxFilesize: 0.5,
                headers: { "X-CSRF-TOKEN": csrfToken },
                params: {
                    binder_id: ""
                },
                paramName: "image", // name属性として扱われる
                maxFilesize: 10, //MB このサイズを超えるとerrorイベントが発火
                clickable: false, // クリックでファイル保存ダイアログを表示しない
                processing: function(file, response) {
                    // プレビューを削除する
                    file.previewElement.outerHTML = "";
                    // Dropzoneを非表示にする
                    self.hideDropzone();
                },
                dragleave: function(file, response) {
                    // Dropzoneを非表示にする
                    self.hideDropzone();
                },
                dragend: function(file, response) {
                    self.hideDropzone();
                },
                drop: function(file, response) {
                    // ドロップする度にstateのバインダーIDを取得する
                    // NOTE: Dropzone初期化時点でバインダー情報取得APIの処理が終了していないため
                    this.options.params.binder_id = self.$store.state.binder.id;
                    self.hideDropzone();
                },
                error: function(e) {
                    console.log(e);
                },
                complete: function(file, response) {
                    // バインダー情報をリロード
                    self.$store.dispatch("binder/fetchBinder", self.$store.state.binder.id)
                }
            }
        };
    },
    methods: {
        hideDropzone() {
            this.$store.commit("mode/setIsShowDropzone", false);
        }
    },
    computed: {
        // NOTE: 処理完了前に非表示とすると処理が中断されるため、z-indexで表示を制御する
        isShow() {
            return this.$store.state.mode.isShowDropzone;
        }
    }
};
</script>
