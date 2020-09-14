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
import { STATUS, MESSAGE, MESSAGE_TYPE } from "../../const";
import { util } from "../../util";

import ImageContainerThumbnail from "./ImageContainerThumbnail.vue";
export default {
    components: {
        VueDropzone: vue2Dropzone,
        ImageContainerThumbnail
    },
    data: function() {
        const self = this;
        const csrfToken = decodeURIComponent(util.getCookieValue('XSRF-TOKEN'));
        return {
            dropzoneOptions: {
                url: "/api/binder/image/add",
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    "X-XSRF-TOKEN": csrfToken
                },
                params: {
                    binder_id: ""
                },
                paramName: "images", // name属性として扱われる
                maxFilesize: 265, //MB このサイズを超えるとerrorイベントが発火
                clickable: false, // クリックでファイル保存ダイアログを表示しない
                uploadMultiple: true, // 複数ファイルアップロードのイベントを利用する
                parallelUploads: 10, // 一度のリクエストでアップロードするファイル数
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
                processingmultiple: function(file, response) {
                    // Dropzoneを非表示にする
                    self.hideDropzone();
                    // プログレスインジケーターを表示する
                    self.$store.commit("mode/setIsConnecting", true);
                },
                errormultiple: function(file, response) {
                    // レスポンスに含まれるメッセージを展開
                    const errorMessageValues = Object.values(
                        response.errors
                    ).flat(1);
                    // 重複を除去
                    const uniquedErrorMessageValues = [
                        ...new Set(errorMessageValues)
                    ];

                    // エラーメッセージの表示
                    const errorMessages = uniquedErrorMessageValues.map(
                        text => {
                            // 通知メッセージのフォーマットへレスポンスを変換
                            return util.createMessage(text, MESSAGE_TYPE.ERROR);
                        }
                    );
                    self.$store.dispatch("messageBox/addMany", errorMessages);
                },
                successmultiple: function() {
                    // バインダー情報をリロード
                    self.$store.dispatch(
                        "binder/fetchBinder",
                        self.$store.state.binder.id
                    );
                    return false;
                },
                completemultiple: function(file, response) {
                    // プログレスインジケーターを消す
                    self.$store.commit("mode/setIsConnecting", false);
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
