<template>
    <div class="image-list__item">
        <div class="image-list__item-thumbnail">
            <img
                class="image-list__item-thumbnail-image"
                :id="`image-list-item-thumbnail-${id}`"
                :alt="fileName"
                :src="imageSource"
            />
        </div>
        <div class="image-list__item-text">
            <p
                @dblclick.stop="startEditFileNameMode($event)"
                v-show="!isEditMode"
                class="image-list__item-text-read"
            >
                {{ fileName }}
            </p>
            <textarea
                ref="fileNameEditForm"
                v-show="isEditMode"
                v-model="editName"
                :id="`file-name-edit-${id}`"
                @keydown.enter="doEditFileName($event)"
                @blur="cancelEditFileName($event)"
                class="image-list__item-text-edit"
            ></textarea>
        </div>
    </div>
    <!-- /.image-list__item -->
</template>

<script>
export default {
    data() {
        return {
            isEditMode: false,
            editName: this.fileName
        };
    },
    props: {
        index: Number,
        id: Number,
        imageSource: String,
        fileName: String
    },
    methods: {
        /**
         * リストアイテムのファイル名編集を開始します。
         */
        startEditFileNameMode(event) {
            this.isEditMode = true;
            // NOTE: dataの更新が画面に反映されてからフォーカスを実行する
            this.$nextTick(() => {
                // フォーカス + テキスト全選択
                this.$refs.fileNameEditForm.focus();
                this.$refs.fileNameEditForm.select();
            });
        },
        /**
         * リストアイテムのファイル名編集をキャンセルします。
         */
        cancelEditFileName(event) {
            // 編集前の値に戻す
            this.editName = this.fileName;
            this.isEditMode = false;
        },
        /**
         * 画像のリネームを確定します。
         *
         * NOTE: 画像名が変更されていない場合はリクエストを送信しない
         */
        async doEditFileName(event) {
            const isBlurEvent = event.type == "blur";
            if (isBlurEvent) {
                // エンター押下とブラーが同時に発火するため、多重処理を防止
                return false;
            }
            this.isEditMode = false;

            // ファイル名が変更されていない場合はリクエストを送信しない。
            const isNotModified = this.fileName == this.editName;
            if (isNotModified) {
                return false;
            }

            // ファイル名更新
            const postData = {
                id: this.id,
                name: this.editName
            };
            await this.$store.dispatch("binder/updateImageName", postData);

            // 画像をリロード
            await this.$store.dispatch("binder/fetchImage", this.index);

            // リロードしたファイル名を設定
            this.editName = this.fileName;
        }
    }
};
</script>
