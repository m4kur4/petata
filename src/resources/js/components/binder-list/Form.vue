<template>
    <form class="form--binder-list">
        <FormTitle :clazz="'form__title--binder-list'">
            <template v-slot:title>Binder list</template>
            <template v-slot:additional-content>
                <AddBinderButton />
            </template>
        </FormTitle>
        <div class="form__nav--binder-list">
            <ul class="form__tab-wrapper">
                <li
                    @click="clearAllFlagCondition"
                    :class="{
                        'form__tab-all': isSetFlagConditions,
                        'form__tab-all--select': !isSetFlagConditions
                    }"
                >
                    <h3 class="form__tab-text">All</h3>
                </li>
                <li
                    @click="setConditionOwn"
                    :class="{
                        'form__tab-own': !isSetConditionOwn,
                        'form__tab-own--select': isSetConditionOwn
                    }"
                >
                    <h3 class="form__tab-text">Own</h3>
                </li>
                <li
                    @click="setConditionOthers"
                    :class="{
                        'form__tab-others': !isSetConditionOthers,
                        'form__tab-others--select': isSetConditionOthers
                    }"
                >
                    <h3 class="form__tab-text">Others</h3>
                </li>
                <li
                    @click="setConditionFavorite"
                    :class="{
                        'form__tab-favorite': !isSetConditionFavorite,
                        'form__tab-favorite--select': isSetConditionFavorite
                    }"
                >
                    <h3 class="form__tab-text">Favorite</h3>
                </li>
            </ul>
            <div class="form__tab-sort-wrapper"></div>
            <div class="form__tab-search-wrapper">
                <button
                    @click="searchBinder"
                    type="button"
                    class="form__tab-search-button"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="30px"
                        height="30px"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                        />
                    </svg>
                </button>
                <input
                    @keydown.enter.prevent="searchBinder"
                    v-model="searchConditionBinderName"
                    ref="searchTextForm"
                    class="form__tab-search-text"
                    type="text"
                    placeholder="Search"
                />
            </div>
        </div>

        <transition-group name="fade-faster" tag="div" class="form__binder-card-wrapper">
            <Card
                v-for="binder in binders"
                :key="binder.id"
                :id="binder.id"
                :name="binder.name"
                :description="binder.description"
                :thumbnailUrl="binder.thumbnail_url"
                :countUser="binder.count_user"
                :countImage="binder.count_image"
                :countLabel="binder.count_label"
                :countFavorite="binder.count_favorite"
                :isOwn="binder.is_own"
                :isFavorite="binder.is_favorite"
                :binder="binder"
            />
        </transition-group>
    </form>
    <!-- /.form -->
</template>

<script>
import FormTitle from "../common/FormTitle.vue";
import Card from "./Card.vue";
import AddBinderButton from "./AddBinderButton.vue";

export default {
    components: {
        FormTitle,
        Card,
        AddBinderButton
    },
    computed: {
        binders() {
            return this.$store.state.binderList.binders;
        },
        /**
         * 検索条件「自分が作成したバインダー」が設定されているかどうかを判定します。
         */
        isSetConditionOwn() {
            return this.$store.state.binderList.search_condition.is_own;
        },
        /**
         * 検索条件「他人が作成したバインダー」が設定されているかどうかを判定します。
         */
        isSetConditionOthers() {
            return this.$store.state.binderList.search_condition.is_others;
        },
        /**
         * 検索条件「自分がお気に入り登録したバインダー」が設定されているかどうかを判定します。
         */
        isSetConditionFavorite() {
            return this.$store.state.binderList.search_condition.is_favorite;
        },
        /**
         * フラグ値の検索条件が設定されているかどうかを判定します。
         */
        isSetFlagConditions() {
            const result =
                this.isSetConditionOwn ||
                this.isSetConditionOthers ||
                this.isSetConditionFavorite;

            return result;
        },
        /**
         * 検索条件「バインダー名」を双方向バインドします。
         */
        searchConditionBinderName: {
            get() {
                return this.$store.state.binderList.search_condition
                    .binder_name;
            },
            set(val) {
                this.$store.commit(
                    "binderList/setSearchConditionBinderName",
                    val
                );
            }
        }
    },
    methods: {
        /**
         * フラグ値の検索条件設定状態をクリアして再検索します。
         */
        clearAllFlagCondition() {
            if (!this.isSetFlagConditions) {
                // クリア済みの場合は実行しない
                return;
            }
            this.$store.dispatch("binderList/clearAllFlagSearchCondition");
            this.searchBinder();
        },
        /**
         * 検索条件「自分が作成したバインダー」を設定して再検索します。
         */
        setConditionOwn() {
            if (this.isSetConditionOwn) {
                // 設定済みの場合は実行しない
                return;
            }
            this.$store.dispatch("binderList/clearAllFlagSearchCondition");
            this.$store.commit("binderList/setSearchConditionBinderOwn", true);
            this.searchBinder();
        },
        /**
         * 検索条件「他人が作成したバインダー」を設定して再検索します。
         */
        setConditionOthers() {
            if (this.isSetConditionOthers) {
                // 設定済みの場合は実行しない
                return;
            }
            this.$store.dispatch("binderList/clearAllFlagSearchCondition");
            this.$store.commit(
                "binderList/setSearchConditionBinderOthers",
                true
            );
            this.searchBinder();
        },
        /**
         * 検索条件「自分がお気に入り登録したバインダー」を設定して再検索します。
         */
        setConditionFavorite() {
            if (this.isSetConditionFavorite) {
                // 設定済みの場合は実行しない
                return;
            }
            this.$store.dispatch("binderList/clearAllFlagSearchCondition");
            this.$store.commit(
                "binderList/setSearchConditionBinderFavorite",
                true
            );
            this.searchBinder();
        },
        /**
         * バインダーの検索を実行します。
         */
        searchBinder() {
            this.$store.dispatch("binderList/searchBinder");
        }
    }
};
</script>
