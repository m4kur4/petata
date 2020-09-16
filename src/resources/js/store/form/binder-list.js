/**
 * フォームデータストア - バインダー一覧
 */
import { STATUS, MESSAGE, MESSAGE_TYPE } from "../../const";
import Vue from "vue";

const state = {
    /**
     * binders: Array バインダーのリスト
     *   - id: String バインダーID
     *   - name: String バインダー名
     *   - description: String バインダーの説明
     *   - count_user: Number 参加者数
     *   - count_image: Number 画像数
     *   - count_label: Number ラベル数
     *   - count_favorite: Number お気に入り登録数
     *   - is_own: Boolean ログインユーザーが作成者かどうか
     *   - is_favorite: Boolean ログインユーザーがお気に入り登録しているかどうか
     * search_condition: Object バインダーの絞り込み条件
     *   - is_own: Booolean ログインユーザーが作成したバインダー
     *   - is_others: Booolean ログインユーザー以外が作成したバインダー
     *   - is_favorite: Booolean ログインユーザーがお気に入り登録したバインダー
     *   - binder_name: String バインダー名
     */
    binders: [],
    search_condition: {
        is_own: false,
        is_others: false,
        is_favorite: false,
        binder_name: ""
    }
};

const mutations = {
    setBinders(state, data) {
        state.binders = data;
    },
    setSearchCondition(state, val) {
        state.search_condition = val;
    },
    setSearchConditionBinderOwn(state, val) {
        state.search_condition.is_own = val;
    },
    setSearchConditionBinderOthers(state, val) {
        state.search_condition.is_others = val;
    },
    setSearchConditionBinderFavorite(state, val) {
        state.search_condition.is_favorite = val;
    },
    setSearchConditionBinderName(state, val) {
        state.search_condition.binder_name = val;
    }
};

const actions = {
    /**
     * バインダー一覧情報を取得します。
     */
    async fetchBinders(context) {
        // ローディング画像の表示
        context.commit("mode/setIsLoading", true, {
            root: true
        });
        const response = await axios.get("api/binder/list");

        // 検索条件を初期化
        context.dispatch("clearSearchCondition");

        if (response.status === STATUS.OK) {
            context.commit("setBinders", response.data);
        } else {
            // 失敗時はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
        }
        // ローディング画像を非表示
        context.commit("mode/setIsLoading", false, {
            root: true
        });
    },
    /**
     * 指定したバインダーについて、ログインユーザーのお気に入り状態を変更します。
     * お気に入り登録されていない場合は新たにお気に入りへ登録し、
     * それ以外の場合はお気に入りを解除します。
     */
    async updateFavoriteState(context, binderId) {
        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        const postData = {
            binder_id: binderId
        };
        const response = await axios.post("api/binder/favorite", postData);

        // 成功
        if (response.status === STATUS.OK) {
            // stateを更新
            const target = state.binders.find(item => item.id == binderId);
            target.is_favorite = !target.is_favorite;

            // バインダーを再検索
            context.dispatch("searchBinder");
            context.dispatch("setProgressIndicatorVisibleState", false);
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
        }
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * バインダーを削除します。
     */
    async deleteBinder(context, binderId) {
        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        const uri = "api/binder/delete";
        const postData = {
            binder_id: binderId
        };
        const response = await axios.post(uri, postData);

        // 成功
        if (response.status === STATUS.OK) {
            // バインダー情報を再取得する
            context.dispatch("fetchBinders");
            context.dispatch("setProgressIndicatorVisibleState", false);

            const message = util.createMessage(
                MESSAGE.BINDER_LIST.SUCCESS.DELETE_BINDER,
                MESSAGE_TYPE.SUCCESS
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
        }
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * stateに保持している条件でバインダーを検索します。
     */
    async searchBinder(context) {
        // ローディング画像の表示
        context.commit("mode/setIsLoading", true, {
            root: true
        });

        const uri = "api/binder/search";
        const response = await axios.get(uri, {
            params: state.search_condition
        });

        // 成功
        if (response.status === STATUS.OK) {
            // バインダー情報を再取得する
            context.commit("setBinders", response.data);

            // ローディング画像の表示
            context.commit("mode/setIsLoading", false, {
                root: true
            });
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
        }
        // ローディング画像の表示
        context.commit("mode/setIsLoading", false, {
            root: true
        });
    },
    /**
     * 通信中であることを示すプログレスインジケーターの表示状態を設定します。
     */
    async setProgressIndicatorVisibleState(context, val) {
        context.commit("mode/setIsConnecting", val, { root: true });
    },
    /**
     * フラグ値の検索条件(is_ownなど)をクリアします。
     * NOTE: フラグ値の検索条件は同時に一つだけ設定可能とするため
     */
    clearAllFlagSearchCondition(context) {
        context.commit("setSearchConditionBinderOwn", false);
        context.commit("setSearchConditionBinderOthers", false);
        context.commit("setSearchConditionBinderFavorite", false);
    },
    /**
     * 検索条件をクリアします。
     */
    clearSearchCondition(context) {
        const defaultSearchCondition = {
            is_own: false,
            is_others: false,
            is_favorite: false,
            binder_name: ""
        };
        context.commit("setSearchCondition", defaultSearchCondition);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
