<template>
    <div
        @dragenter="dragEnter($event)"
        @dragleave="dragLeave($event)"
        @drop.prevent="drop($event)"
        :class="[
            'label-container__item',
            'mdc-elevation--z2',
            {
                dragging: isDraggingImage,
                'already-labeling': isDraggingLabelingImage,
                'dragover--danger': isDraggingLabelingImage && isDragEnter,
                dragover: !isDraggingLabelingImage && isDragEnter
            }
        ]"
    >
        <p class="label-container__item-title">{{ name }}</p>
        <div
            v-if="isRemoveConfirm"
            @mouseleave="switchRemoveConfirm"
            class="label-container__item-confirm-wrapper"
        >
            <button
                @click="removeLabel"
                type="button"
                class="label-container__item-confirm-ok"
            >
                <!-- ラベル削除確定ボタン -->
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
                @click="switchRemoveConfirm"
                type="button"
                class="label-container__item-confirm-no"
            >
                <!-- ラベル削除キャンセルボタン -->
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
        <div class="label-container__item-button-wrapper">
            <button
                v-if="isBinderDetail"
                @click="switchSearchCondition"
                type="button"
                :class="{
                    'label-container__item-button--selected': isAddSearchCondition,
                    'label-container__item-button': !isAddSearchCondition
                }"
            >
                <!-- クリップボタン(バインダー画面のみ表示) -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="24"
                    viewBox="0 0 24 24"
                    width="24"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M18 13v7H4V6h5.02c.05-.71.22-1.38.48-2H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-5l-2-2zm-1.5 5h-11l2.75-3.53 1.96 2.36 2.75-3.54zm2.8-9.11c.44-.7.7-1.51.7-2.39C20 4.01 17.99 2 15.5 2S11 4.01 11 6.5s2.01 4.5 4.49 4.5c.88 0 1.7-.26 2.39-.7L21 13.42 22.42 12 19.3 8.89zM15.5 9C14.12 9 13 7.88 13 6.5S14.12 4 15.5 4 18 5.12 18 6.5 16.88 9 15.5 9z"
                    />
                </svg>
            </button>
            <button
                @click="openLabelAddDialogForEdit"
                type="button"
                class="label-container__item-button"
            >
                <!-- 編集ボタン -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="24"
                    viewBox="0 0 24 24"
                    width="24"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"
                    />
                </svg>
            </button>
            <button
                @click="switchRemoveConfirm"
                type="button"
                class="label-container__item-button--danger"
            >
                <!-- 削除ボタン -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 24 24"
                    width="24px"
                    height="24px"
                >
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM8 9h8v10H8V9zm7.5-5l-1-1h-5l-1 1H5v2h14V4z"
                    />
                </svg>
            </button>
        </div>

        <p class="label-container__item-description">
            {{ description }}
        </p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            isRemoveConfirm: false,
            // ドラッグイベントの制御パラメタ
            isDragEnter: false
        };
    },
    props: {
        index: null,
        id: null,
        name: "",
        description: ""
    },
    computed: {
        /**
         * バインダー詳細画面を開いているかどうか
         * NOTE:画像絞り込み用のピンボタンはバインダー作成画面で非表示
         */
        isBinderDetail() {
            return this.$store.state.binder.id != null;
        },
        /**
         * 自身のラベルIDがstateの検索条件へ追加されているかどうか
         */
        isAddSearchCondition() {
            return this.$store.getters[
                "binder/isAlreadyAddSearchConditionLabel"
            ](this.id);
        },
        /**
         * 自身とラベリングされているバインダー画像がドラッグ中かどうか
         */
        isDraggingLabelingImage() {
            return this.$store.getters[
                "binder/isLabelingWithDraggingImageLabel"
            ](this.id);
        },
        /**
         * バインダー画像がドラッグ中かどうか
         */
        isDraggingImage() {
            return this.$store.state.binder.is_dragging_image;
        }
    },

    methods: {
        /**
         * ラベリング実行のためのドラッグイベントです。
         * NOTE: ドロップ時、dataTransfer.getData('image-id')で画像のIDを取得
         */
        dragEnter(event) {
            // スタイルを変更
            this.isDragEnter = true;
        },
        dragLeave(event) {
            // スタイルを変更
            this.isDragEnter = false;
        },
        drop(event) {
            const imageId = event.dataTransfer.getData("image-id");
            if (!!!imageId) {
                // バインダーの画像以外がドロップされた場合は処理なし
                return false;
            }
            const labelId = this.id;

            // ラベルと画像を関連付ける
            const postData = {
                label_id: labelId,
                image_id: imageId
            };
            this.$store.dispatch("binder/labeling", postData);

            // ラベリングした画像をリロードする
            const imageIndex = event.dataTransfer.getData("image-index");
            this.$store.dispatch("binder/fetchImage", imageIndex);

            // スタイルを変更
            this.isDragEnter = false;
        },
        /**
         * 自身に関するバインダー画面の絞り込み条件を切り替えます。
         *
         * 条件「対象画像が自身のIDとラベリング設定されていること」について、
         * 条件が設定されていなければ新たに追加を行い、
         * 既に条件が設定済みの場合は除去します。
         */
        async switchSearchCondition() {
            await this.$store.commit("binder/setSearchConditionLabel", this.id);
            this.searchBinderImage();
        },
        /**
         * バインダー画像の検索APIを呼び出します。
         */
        searchBinderImage() {
            this.$store.dispatch("binder/searchBinderImage");
        },
        /**
         * ラベル追加ダイアログを編集モードで呼び出します。
         */
        openLabelAddDialogForEdit() {
            // 初期値の設定
            this.$store.commit("labelAddDialog/setMode", "Edit");
            this.$store.commit("labelAddDialog/setId", this.id);
            this.$store.commit("labelAddDialog/setIndex", this.index);
            this.$store.commit("labelAddDialog/setName", this.name);
            this.$store.commit(
                "labelAddDialog/setDescription",
                this.description
            );
            this.$store.commit("mode/setIsShowDialog", true);
        },
        /**
         * ラベルの削除確認表示を切り替えます。
         */
        switchRemoveConfirm() {
            this.isRemoveConfirm = !this.isRemoveConfirm;
        },
        /**
         * ラベル削除イベントを発火します。
         * カスタムイベント名："remove-label-click"
         */
        async removeLabel() {
            const label = {
                index: this.index,
                label_id: this.id
            };
            this.isRemoveConfirm = false;

            // NOTE: 削除処理は親コンポーネントへ委譲する
            await this.$emit("remove-label-click", label);

            // バインダー画像の検索条件から自身を除去
            if (this.isAddSearchCondition) {
                // NOTE: stateへ設定済みの場合は削除される
                this.$store.commit("binder/setSearchConditionLabel", this.id);
            }
            // バインダー画像を再検索
            this.searchBinderImage();
        }
    }
};
</script>
