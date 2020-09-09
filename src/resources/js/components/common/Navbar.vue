<template>
    <nav v-if="isShowNav" class="nav mdc-elevation--z2">
        <div class="nav__left-column-wrapper">
            <button
                v-tooltip.bottom="{
                    content:
                        '[未実装]画像を複数選択してzip形式で一括ダウンロードします。'
                }"
                class="nav__button"
            >
                <!-- 画像一括ダウンロードボタン(ダウンロード) -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="44"
                    viewBox="0 0 24 24"
                    width="44"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"
                    />
                </svg></button
            ><button
                v-tooltip.bottom="{
                    content:
                        '[未実装]zip形式に圧縮した画像ファイルを一括アップロードします。'
                }"
                class="nav__button"
            >
                <!-- 画像一括アップロードボタン(ダウンロード) -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="44"
                    viewBox="0 0 24 24"
                    width="44"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"
                    />
                </svg></button
            ><button
                v-tooltip.bottom="{
                    content: '[未実装]画像を複数選択して一括で削除します。'
                }"
                class="nav__button"
            >
                <!-- 画像一括削除ボタン(ごみ箱) -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="44"
                    viewBox="0 0 24 24"
                    width="44"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"
                    />
                </svg>
            </button>
        </div>
        <div class="nav__title-wrapper">
            <h1 class="nav__title">
                {{ binderTitle }}
                <svg
                    v-tooltip.right="{
                        content: `[${binder.created_at} -]${
                            !!binder.description
                                ? '<br>' +
                                  binder.description.replace(/\n/g, '<br>')
                                : ''
                        }`
                    }"
                    xmlns="http://www.w3.org/2000/svg"
                    height="24"
                    viewBox="0 0 24 24"
                    width="24"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"
                    />
                </svg>
            </h1>
        </div>
        <div class="nav__right-column-wrapper">
            <button
                v-tooltip.left="{
                    content: 'ラベルを追加します。'
                }"
                :class="{
                    'nav__button-wide': !isDraggingImage && !isShowDialog,
                    'nav__button-wide--showDialog': isShowDialog,
                    'nav__button-wide--draggingImage': isDraggingImage
                }"
                @click="openDialog"
            >
                <!-- ラベル追加ボタン -->
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="48"
                    viewBox="0 0 24 24"
                    width="48"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path
                        class="add-icon"
                        d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"
                    />
                    <path
                        fill="none"
                        class="add-icon--hover"
                        d="M20 12l-1.41-1.41L13 16.17V4h-2v12.17l-5.58-5.59L4 12l8 8 8-8z"
                    />
                </svg>
            </button>
            <span class="nav__button-wrapper--right"
                ><button
                    v-tooltip.bottom="{
                        content: '[未実装]画像を複数選択して一括でラベリングを行います。'
                    }"
                    class="nav__button"
                >
                    <!-- ラベル一括追加ボタン(しおり) -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="40"
                        viewBox="0 0 24 24"
                        width="40"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7zm11.77 8.27L13 19.54l-4.27-4.27C8.28 14.81 8 14.19 8 13.5c0-1.38 1.12-2.5 2.5-2.5.69 0 1.32.28 1.77.74l.73.72.73-.73c.45-.45 1.08-.73 1.77-.73 1.38 0 2.5 1.12 2.5 2.5 0 .69-.28 1.32-.73 1.77z"
                        />
                    </svg></button
                ><button
                    v-tooltip.bottom="{
                        content: 'バインダー一覧へ戻ります。'
                    }"
                    @click="moveToBinderList"
                    class="nav__button"
                >
                    <!-- 前の画面へ戻るボタン(リターンキー矢印) -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="48"
                        viewBox="0 0 24 24"
                        width="48"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M19 7v4H5.83l3.58-3.59L8 6l-6 6 6 6 1.41-1.41L5.83 13H21V7z"
                        />
                    </svg></button
            ></span>
        </div>
        <ProgressIndicator />
        <LabelAddDialog @add-label-click="saveLabel" />
    </nav>
</template>

<script>
import ProgressIndicator from "../common/ProgressIndicator.vue";
import LabelAddDialog from "../common/LabelAddDialog.vue";

export default {
    components: {
        ProgressIndicator,
        LabelAddDialog
    },
    computed: {
        binderTitle() {
            return this.$store.state.binder.name;
        },
        isShowNav() {
            return this.$store.state.mode.hasNavigation;
        },
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
        isDraggingImage() {
            return this.$store.state.binder.is_dragging_image;
        },
        binder() {
            return this.$store.state.binder;
        }
    },
    methods: {
        moveToBinderList() {
            this.$router.push("/binder/list");
        },
        openDialog() {
            this.$store.commit("mode/setIsShowDialog", true);
        },
        /**
         * ラベルダイアログの入力内容を保存します。
         */
        saveLabel(labelData) {
            // NOTE: ナビゲーションバーから展開したラベルダイアログの内容は非同期で保存する
            labelData.binder_id = this.$store.state.binder.id;
            this.$store.dispatch("binder/saveLabel", labelData);
        }
    }
};
</script>
