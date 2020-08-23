/**
 * フォームデータストア - バインダー一覧
 */
import { STATUS } from "../../const";

const state = {
    /**
     * id: String
     * name: String
     * description: String
     * count_user: Number
     * count_image: Number
     * count_label: Number
     * count_favorite: Number
     * is_own: Boolean
     * is_favorite: Boolean
     */
    binders: []
};

const mutations = {
    setBinders(state, data) {
        state.binders = data;
    },
};

const actions = {
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
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
