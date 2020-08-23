/**
 * フォームデータストア - バインダー作成
 */
import { STATUS } from "../../const";

const state = {
    /**
     * name: String バインダー名
     * description: String バインダーの説明
     * labels: Array ラベルの配列
     *   - name: String ラベル名
     *   - description: String ラベルの説明
     */
    form: {
        name: '',
        description: '',
        labels: []
    },

    /**
     * エラーメッセージ
     */
    errorMessages: null
};

const mutations = {
    setBinderName(state, val) {
        state.form.name = val;
    },
    setBinderDescription(state, val) {
        state.form.description = val;
    },
    setLabels(state, val) {
        state.form.labels = val;
    },
    addLabel(state, label) {
        state.form.labels.push(label);
    },
    removeLabel(state, key) {
        // TODO: 実装
        // TODO: 削除対象のラベルをどうやって識別するか
    }
};

const actions = {
    async doPost(context) {

        const uri = "api/binder/create";
        const response = await axios
            .post(`${uri}`, state.form)
            .catch(err => err.response || err);

        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
            alert('成功しました。');
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
    },
    /**
     * フォームを初期化します。
     */
    initialize() {
        const defaultForm = {
            name: '',
            description: '',
            labels: []
        };

        state.form = defaultForm;
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
