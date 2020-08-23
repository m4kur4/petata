/**
 * フォームデータストア - バインダー一覧
 */
import { STATUS } from "../../const";

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
    },
};

const actions = {
    /**
     * バインダー一覧情報を取得します。
     */
    async fetchBinders(context) {

        const response = await axios.get("api/binder/list");
        
        if(response.status === STATUS.OK) {
            context.commit("setBinders", response.data);
        
        } else {
            // 失敗時はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
                root: true
            });
        }
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
