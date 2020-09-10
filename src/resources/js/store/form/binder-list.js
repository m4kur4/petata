/**
 * フォームデータストア - バインダー一覧
 */
import { STATUS } from "../../const";
import Vue from 'vue';

const state = {
    /**
     * id: String バインダーID
     * name: String バインダー名
     * description: String バインダーの説明
     * count_user: Number 参加者数
     * count_image: Number 画像数
     * count_label: Number ラベル数
     * count_favorite: Number お気に入り登録数
     * is_own: Boolean ログインユーザーが作成者かどうか
     * is_favorite: Boolean ログインユーザーがお気に入り登録しているかどうか
     */
    binders: []
};

const mutations = {
    setBinders(state, data) {
        state.binders = data;
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

        if (response.status === STATUS.OK) {
            context.commit("setBinders", response.data);
        } else {
            // 失敗時はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
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
            'binder_id': binderId
        };
        const response = await axios.post("api/binder/favorite", postData);

        // 成功
        if (response.status === STATUS.OK) {
            // stateを更新
            const target = state.binders.find(item => item.id == binderId);
            target.is_favorite = !target.is_favorite;

            context.dispatch("setProgressIndicatorVisibleState", false);
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.data.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
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
            'binder_id': binderId
        };
        const response = await axios.post(uri, postData);

        // 成功
        if (response.status === STATUS.OK) {
            // バインダー情報を再取得する
            context.dispatch("fetchBinders");

            context.dispatch("setProgressIndicatorVisibleState", false);
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.data.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
                root: true
            });
        }
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 通信中であることを示すプログレスインジケーターの表示状態を設定します。
     */
    async setProgressIndicatorVisibleState(context, val) {
        context.commit('mode/setIsConnecting', val, { root: true }) ;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
