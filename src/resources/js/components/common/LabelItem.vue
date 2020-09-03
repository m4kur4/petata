<template>
    <div
        @dragenter.prevent="dragEnter($event)"
        @drop.prevent="drop($event)"
        class="label-container__item mdc-elevation--z2"
    >
        <p class="label-container__item-title">{{ name }}</p>
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
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path
                        d="M2 12.5C2 9.46 4.46 7 7.5 7H18c2.21 0 4 1.79 4 4s-1.79 4-4 4H9.5C8.12 15 7 13.88 7 12.5S8.12 10 9.5 10H17v2H9.41c-.55 0-.55 1 0 1H18c1.1 0 2-.9 2-2s-.9-2-2-2H7.5C5.57 9 4 10.57 4 12.5S5.57 16 7.5 16H17v2H7.5C4.46 18 2 15.54 2 12.5z"
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
            <button type="button" class="label-container__item-button--danger">
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
    props: {
        index: null,
        id: null,
        name: "",
        description: "",
        // ドラッグイベントの制御パラメタ
        isDragOver: false,
        isDragEnter: false
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
        }
    },
    /**
     * ラベリングを実行します。
     */
    methods: {
        dragEnter(event) {
            // TODO: ドロップできる旨のUI表現
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
        }
    }
};
</script>
