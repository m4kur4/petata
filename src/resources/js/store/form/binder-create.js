/**
 * フォームデータストア - バインダー作成
 */
import { STATUS } from "../../const";
import Vue from 'vue';

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
        labels: [],
        sort: null
    },
    /**
     * ラベルのカウント
     */
    label_count: 0,

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
    setLabel(state, label) {
        if (label.index == null) {
            // 新規追加の場合はstateにpushする
            state.form.labels.push(label);
        } else {
            // 編集の場合はstateを更新する
            Vue.set(state.form.labels, label.index, label);
            console.log(state.form.labels[label.index]);
        }
    },
    removeLabel(state, label) {
        Vue.delete(state.form.labels, label.index);
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
    clear() {
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
