<template>
    <div
        @dragend="focusImage"
        :image-id="id"
        :index="index"
        class="image-list__item"
    >
        <div
            @click="focusImage"
            @dblclick="showLightBox"
            class="image-list__item-thumbnail"
        >
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
            editName: this.fileName,
            /**
             * サムネイルがクリックされた際にセットされるタイマー
             * NOTE: クリックとダブルクリックで処理を分岐させるため(#20)
             */
            timerForJudgeClickEvent: null
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
        },
        /**
         * 指定したリストアイテムに該当するバインダー画像をフォーカスします。
         * 当該リストアイテムまで画像コンテナをスクロールします。
         */
        focusImage(event) {
            // ダブルクリックと判定されるクリック間隔(ms)
            const dblclickSpan = 100;

            // ダブルクリック時に2回処理が発火しないようにする
            if (this.timerForJudgeClickEvent) {
                clearTimeout(this.timerForJudgeClickEvent);
            }

            const self = this;
            this.timerForJudgeClickEvent = setTimeout(function() {
                const imageContainer = document.getElementById(
                    "image-container"
                );
                const target = document.getElementById(`image-${self.id}`);

                // 座標を取得
                const containerClientRect = imageContainer.getBoundingClientRect();
                const targetClientRect = target.getBoundingClientRect();

                // 画像コンテナの位置情報
                const containerTop = containerClientRect.top;
                const containerHeight = containerClientRect.height;
                const containerBottom = containerTop + containerHeight;

                // フォーカス対象画像の位置情報
                const targetTop = targetClientRect.top;
                const targetHeight = targetClientRect.height;
                const targetBottom = targetTop + targetHeight;

                // 画像がコンテナの表示領域に納まっているかどうか
                const isLowerContainerTop = containerTop < targetTop;
                const isUpperContainerBottom = targetBottom < containerBottom;
                const isInnerDisplayArea =
                    isLowerContainerTop && isUpperContainerBottom;

                // 画像の枠を表示
                self.$store.commit("binder/setFocusedImageId", self.id);

                if (isInnerDisplayArea) {
                    // 表示領域内にいる場合は後続処理なし
                    return false;
                }

                // イベントの種類に応じてスクロール処理を実行
                let targetTopAfter;

                if (event.type == "click") {
                    // NOTE: 画像位置は「imageContainer.scrollTop」に対する位置で可変
                    const diff = targetTop - containerTop;
                    targetTopAfter = imageContainer.scrollTop + diff - 18;
                } else if (event.type == "dragend") {
                    // NOTE: ドラッグは画像が移動するため「移動後の画像位置」を基準としてスクロール
                    targetTopAfter = targetTop - containerTop - 18;
                }
                imageContainer.scrollTop = targetTopAfter;
            }, dblclickSpan);
        },
        /**
         * ライトボックスで画像を表示します。
         * NOTE: 親コンポーネント経由でLightBoxコンポーネントのメソッドを呼びだす
         */
        showLightBox() {
            clearTimeout(this.timerForJudgeClickEvent);
            this.$emit("show-lightbox-click", this.index);
        }
    }
};
</script>
