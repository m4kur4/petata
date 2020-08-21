/**
 * フォームデータストア - バインダー作成
 */
import { STATUS } from "../../const";

const state = {
    /**
     * バインダーの名前
     */
    binderName: null,
    /**
     * バインダーの説明
     */
    binderDescription: null,
    /**
     * ラベル
     * [
     *   label_name: String,
     *   label_description: String
     * ]
     */
    labels: [],
    /**
     * エラーメッセージ
     */
    errorMessages: null
};

const mutations = {
    setBinderName(state, val) {
        state.binderName = val;
    },
    setBinderDescription(state, val) {
        state.binderDescription = val;
    },
    setLabels(state, val) {
        state.labels = val;
    },
    addLabel(state, label) {
        state.labels.push(label);
    },
    removeLabel(state, key) {
        // TODO: 実装
        // TODO: 削除対象のラベルをどうやって識別するか
    }
};

const actions = {
    async execute(context, data) {
        const uri = 'api/binder/create';
        const response = await axios
            .post(`${uri}`, data)
            .catch(err => err.response || err);
        
        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
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
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
