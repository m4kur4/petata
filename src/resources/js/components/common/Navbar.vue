<template>
    <nav v-if="isShowNav" class="nav mdc-elevation--z2">
        <div>
            <transition name="fade-faster" mode="out-in">
                <div
                    class="nav__left-column-wrapper"
                    key="normal"
                    v-if="!isDeleteModeScreen && !isLabelingModeScreen"
                >
                    <button
                        @click="downloadImages"
                        v-tooltip.bottom="{
                            content:
                                '表示中の画像をzip形式で一括ダウンロードします。'
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
                        @click="enableDeleteModeScreen"
                        v-tooltip.bottom="{
                            content: '画像を複数選択して一括で削除します。'
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
                        </svg></button
                    ><button
                        @click="enableLabelingModeScreen"
                        v-tooltip.bottom="{
                            content:
                                '画像を複数選択して一括でラベリングを行います。'
                        }"
                        class="nav__button"
                    >
                        <!-- 一括ラベリングボタン(しおり) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
                            viewBox="0 0 24 24"
                            width="44"
                        >
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7zm11.77 8.27L13 19.54l-4.27-4.27C8.28 14.81 8 14.19 8 13.5c0-1.38 1.12-2.5 2.5-2.5.69 0 1.32.28 1.77.74l.73.72.73-.73c.45-.45 1.08-.73 1.77-.73 1.38 0 2.5 1.12 2.5 2.5 0 .69-.28 1.32-.73 1.77z"
                            />
                        </svg>
                    </button>
                </div>
                <div
                    v-if="isDeleteModeScreen"
                    key="delete"
                    class="nav__left-column-wrapper"
                >
                    <button
                        v-tooltip.bottom="{
                            content: '画像を複数選択して一括で削除します。'
                        }"
                        class="nav__button fix-delete"
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
                        </svg></button
                    ><button @click="multipleDelete" class="nav__button delete">
                        <!-- 画像一括削除ボタン(確定) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
                            viewBox="0 0 24 24"
                            width="44"
                        >
                            <path
                                d="M0 0h24v24H0V0zm0 0h24v24H0V0z"
                                fill="none"
                            />
                            <path
                                d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"
                            />
                        </svg></button
                    ><button @click="setNormalModeScreen" class="nav__button">
                        <!-- 画像一括削除ボタン(キャンセル) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
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
                <div
                    v-if="isLabelingModeScreen"
                    key="labeling"
                    class="nav__left-column-wrapper"
                >
                    <button
                        v-tooltip.bottom="{
                            content:
                                '画像を複数選択して一括でラベリングを行います。'
                        }"
                        class="nav__button fix-labeling"
                    >
                        <!-- 一括ラベリングボタン(しおり) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
                            viewBox="0 0 24 24"
                            width="44"
                        >
                            <path d="M0 0h24v24H0z" fill="none" />
                            <path
                                d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 7C4.67 7 4 6.33 4 5.5S4.67 4 5.5 4 7 4.67 7 5.5 6.33 7 5.5 7zm11.77 8.27L13 19.54l-4.27-4.27C8.28 14.81 8 14.19 8 13.5c0-1.38 1.12-2.5 2.5-2.5.69 0 1.32.28 1.77.74l.73.72.73-.73c.45-.45 1.08-.73 1.77-.73 1.38 0 2.5 1.12 2.5 2.5 0 .69-.28 1.32-.73 1.77z"
                            />
                        </svg></button
                    ><button
                        @click="multipleLabeling"
                        class="nav__button labeling"
                    >
                        <!-- 一括ラベリングボタン(確定) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
                            viewBox="0 0 24 24"
                            width="44"
                        >
                            <path
                                d="M0 0h24v24H0V0zm0 0h24v24H0V0z"
                                fill="none"
                            />
                            <path
                                d="M16.59 7.58L10 14.17l-3.59-3.58L5 12l5 5 8-8zM12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"
                            />
                        </svg></button
                    ><button @click="setNormalModeScreen" class="nav__button">
                        <!-- 一括ラベリングボタン(キャンセル) -->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height="44"
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
            </transition>
        </div>
        <div
            v-tooltip.bottom="{
                content: `[${binder.created_at} -]${
                    !!binder.description
                        ? '<br>' + binder.description.replace(/\n/g, '<br>')
                        : ''
                }`,
                trigger: 'manual',
                show: isShowBinderInfo
            }"
            class="nav__title-wrapper"
        >
            <h1 class="nav__title">
                {{ binderTitle }}
                <svg
                    @mouseenter="switchBinderInfoVisible"
                    @mouseleave="switchBinderInfoVisible"
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
                    @click="moveToUserManual"
                    v-tooltip.bottom="{
                        content: 'アプリケーションの使い方を別タブに表示します。<br>※外部サイト(GitHub)を開きます。'
                    }"
                    class="nav__button"
                >
                    <!-- ヘルプボタン(はてな) -->
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        height="44"
                        viewBox="0 0 24 24"
                        width="44"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M11 18h2v-2h-2v2zm1-16C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm0-14c-2.21 0-4 1.79-4 4h2c0-1.1.9-2 2-2s2 .9 2 2c0 2-3 1.75-3 5h2c0-2.25 3-2.5 3-5 0-2.21-1.79-4-4-4z"
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
import { SCREEN_MODE } from "../../const";
import ProgressIndicator from "../common/ProgressIndicator.vue";
import LabelAddDialog from "../common/LabelAddDialog.vue";

export default {
    data() {
        return {
            isShowBinderInfo: false
        };
    },
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
        },
        /**
         * バインダー画面が選択モード(削除)かどうかを判定します。
         */
        isDeleteModeScreen() {
            const screenMode = this.$store.state.binder.mode;
            return screenMode == SCREEN_MODE.BINDER.DELETE;
        },
        /**
         * バインダー画面が選択モード(ラベリング)かどうかを判定します。
         */
        isLabelingModeScreen() {
            const screenMode = this.$store.state.binder.mode;
            return screenMode == SCREEN_MODE.BINDER.LABELING;
        }
    },
    methods: {
        moveToBinderList() {
            this.closeDialog();
            this.$router.push({ name: "binder-list" });
        },
        openDialog() {
            this.$store.commit("mode/setIsShowDialog", true);
        },
        closeDialog() {
            this.$store.commit("mode/setIsShowDialog", false);
        },
        /**
         * ラベルダイアログの入力内容を保存します。
         */
        saveLabel(labelData) {
            // NOTE: ナビゲーションバーから展開したラベルダイアログの内容は非同期で保存する
            labelData.binder_id = this.$store.state.binder.id;
            this.$store.dispatch("binder/saveLabel", labelData);
        },
        /**
         * バインダー情報を表示します。
         */
        switchBinderInfoVisible() {
            this.isShowBinderInfo = !this.isShowBinderInfo;
        },
        /**
         * バインダー画面の選択モード(削除)を有効化します。
         */
        enableDeleteModeScreen() {
            this.closeDialog();
            this.$store.commit("binder/setMode", SCREEN_MODE.BINDER.DELETE);
        },
        /**
         * バインダー画面の選択モード(ラベリング)を有効化します。
         */
        enableLabelingModeScreen() {
            this.closeDialog();
            this.$store.commit("binder/setMode", SCREEN_MODE.BINDER.LABELING);
        },
        /**
         * バインダー画面を通常モードへ切り替えます。
         */
        setNormalModeScreen() {
            this.$store.commit("binder/setMode", SCREEN_MODE.BINDER.NORMAL);

            // 選択状態のクリア
            this.$store.dispatch("binder/clearSelectedState");
        },
        /**
         * 画像の一括削除を行います。
         */
        async multipleDelete() {
            await this.$store.dispatch("binder/removeImageMultiple", [this.id]);
        },
        /**
         * 一括ラベリングを行います。
         */
        async multipleLabeling() {
            await this.$store.dispatch("binder/labelingMultiple", [this.id]);
        },
        /**
         * 画像の一括ダウンロードを行います。
         */
        async downloadImages() {
            await this.$store.dispatch("binder/downloadImages");
        },
        /**
         * 操作説明ページを開きます。
         */
        moveToUserManual() {
            window.open("https://github.com/makura016/petata#%E4%BD%BF%E3%81%84%E6%96%B9");
        },
    }
};
</script>
