<template>
    <div
        @dragstart="dragStart($event)"
        @dragend="dragEnd($event)"
        @drag="drag($event)"
        :image-id="id"
        :index="index"
        class="image-container__thumbnail"
    >
        <div
            v-if="isSelectModeScreen"
            class="image-container__select-handle-wrapper"
        >
            <!-- 選択モード時のコンテンツ表示要素 -->
            <div class="image-container__select-handle-content">
                <button
                    @click="setSelectedImageId"
                    :class="[
                        'image-container__select-handle-button',
                        { selected: isSelected }
                    ]"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="80"
                        viewBox="0 0 24 24"
                        width="80"
                    >
                        <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"
                        />
                    </svg>
                </button>
            </div>
            <!-- /.image-container__select-handle-content -->
        </div>
        <!-- /.image-container__select-handle-wrapper -->
        <div
            @mouseleave="setIsRemoveConfirm(false)"
            :class="[
                'image-container__thumbnail-inner-content-wrapper',
                { focused: isFocused }
            ]"
        >
            <img
                class="image-container__thumbnail-image mdc-elevation--z2"
                ref="thumbnailImage"
                :image-id="id"
                :id="`image-${id}`"
                :src="imageSource"
                :alt="fileName"
            />

            <button
                v-show="!isDraggableProcessing"
                class="thumbnail-inner-content__handle"
            >
                <!-- Draggable操作用のハンドル -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    enable-background="new 0 0 24 24"
                    height="24"
                    viewBox="0 0 24 24"
                    width="24"
                >
                    <g><rect fill="none" height="24" width="24" /></g>
                    <g>
                        <g>
                            <g>
                                <path d="M20,9H4v2h16V9z M4,15h16v-2H4V15z" />
                            </g>
                        </g>
                    </g>
                </svg>
            </button>

            <div
                v-show="!isDraggableProcessing"
                class="thumbnail-inner-content__button-wrapper"
            >
                <button
                    v-show="!isRemoveConfirm"
                    v-tooltip.bottom="{
                        content: 'クリップボードにコピーしました。',
                        trigger: 'manual',
                        show: isShowCopiedMessage
                    }"
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
                <button
                    v-show="!isRemoveConfirm"
                    @click="showLightBox"
                    class="thumbnail-inner-content__button"
                >
                    <!-- ライトボックス表示 -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M7 14H5v5h5v-2H7v-3zm-2-4h2V7h3V5H5v5zm12 7h-3v2h5v-5h-2v3zM14 5v2h3v3h2V5h-5z"
                        />
                    </svg>
                </button>
                <button
                    v-show="!isRemoveConfirm"
                    @click="setIsRemoveConfirm(true)"
                    class="thumbnail-inner-content__button"
                >
                    <!-- バインダー画像削除 -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path d="M0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zm2.46-7.12l1.41-1.41L12 12.59l2.12-2.12 1.41 1.41L13.41 14l2.12 2.12-1.41 1.41L12 15.41l-2.12 2.12-1.41-1.41L10.59 14l-2.13-2.12zM15.5 4l-1-1h-5l-1 1H5v2h14V4z"
                        />
                    </svg>
                </button>

                <button
                    v-if="isRemoveConfirm"
                    @click="removeImage"
                    class="thumbnail-inner-content__button--danger"
                >
                    <!-- 画像削除確定 -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0V0zm0 0h24v24H0V0z" fill="none" />
                        <path
                            d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"
                        />
                    </svg>
                </button>
                <button
                    v-if="isRemoveConfirm"
                    @click="setIsRemoveConfirm(false)"
                    class="thumbnail-inner-content__button"
                >
                    <!-- 画像削除キャンセル -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M12 2C6.47 2 2 6.47 2 12s4.47 10 10 10 10-4.47 10-10S17.53 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"
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
    data() {
        return {
            /**
             * 画像の削除確認を表示しているかどうか
             */
            isRemoveConfirm: false,
            /**
             * 画像のクリップボードメッセージを表示しているかどうか
             */
            isShowCopiedMessage: false
        };
    },
    props: {
        index: Number,
        id: Number,
        imageSource: String,
        fileName: String,
        labelingLabelIds: Array
    },
    methods: {
        /**
         * ラベリング実行のためのドラッグイベントです。
         * NOTE: ドロップ時、dataTransfer.getData('image-id')で画像のIDを取得
         */
        dragStart(event) {
            // Draggableの処理はラベリング処理から切り離す
            if (util.isDraggableEvent(event)) {
                return false;
            }

            // ラベルアイテムの表示制御用にドラッグ中であることを通知
            this.$store.commit("binder/setIsDraggingImage", true);

            // ラベルへ受け渡すパラメタをdataTransferへ設定
            const dragImage = document.getElementById(
                `image-list-item-thumbnail-${this.id}`
            );
            event.dataTransfer.setDragImage(dragImage, 20, 20);
            event.dataTransfer.setData("image-id", this.id);
            event.dataTransfer.setData("image-index", this.index);

            // ドラッグしている画像のラベリング情報を画面へ反映
            this.$store.commit(
                "binder/setDraggingImageLabelingLabelIds",
                this.labelingLabelIds
            );
        },
        dragEnd(event) {
            // ラベルアイテムの表示制御用にドラッグが完了したことを通知
            this.$store.commit("binder/setIsDraggingImage", false);

            // ラベリングされているラベルの強調表示を終了
            this.$store.commit("binder/setDraggingImageLabelingLabelIds", []);
        },
        drag(event) {
            console.log("移動中");
        },
        /**
         * 画像をクリップボードにコピーします。
         */
        copyImage() {
            const image = this.$refs.thumbnailImage;
            util.copyImageToClipBoard(image, this.id);

            // メッセージの表示
            this.isShowCopiedMessage = true;
            setTimeout(() => {
                this.isShowCopiedMessage = false;
            }, 1100);
        },
        /**
         * ライトボックスで画像を表示します。
         * NOTE: 親コンポーネント経由でLightBoxコンポーネントのメソッドを呼びだす
         */
        showLightBox() {
            this.$emit("show-lightbox-click", this.index);
        },
        /**
         * 画像の削除確認表示を切り替えます。
         */
        setIsRemoveConfirm(val) {
            this.isRemoveConfirm = val;
        },
        /**
         * 画像を削除します。
         */
        async removeImage() {
            // NOTE: 複数画像削除に対応するつくりのため、配列としてIDを渡す
            await this.$store.dispatch("binder/removeImage", [this.id]);
            this.setIsRemoveConfirm(false);
        },
        /**
         * 画像の選択状態を設定します。
         * すでに選択状態である場合、選択状態を解除します。
         */
        setSelectedImageId() {
            this.$store.commit("binder/setSelectedImageId", this.id);
        }
    },
    computed: {
        /**
         * Draggableによるドラッグ操作をしているかどうかを判定します。
         * NOTE: ラベリングのドラッグ操作と処理を分離する
         */
        isDraggableProcessing() {
            return this.$store.state.binder.is_draggable_processing;
        },
        /**
         * ラベルアイテムのクリックによるフォーカスが当たっているかどうかを判定します。
         */
        isFocused() {
            return this.$store.getters["binder/isFocusedImageId"](this.id);
        },
        /**
         * バインダー画面が選択モードかどうかを判定します。
         */
        isSelectModeScreen() {
            return this.$store.getters["binder/isSelectMode"];
        },
        /**
         * 画像が選択状態かどうかを判定します。
         */
        isSelected() {
            return this.$store.getters["binder/isSelectedImageId"](this.id);
        }
    }
};
</script>
