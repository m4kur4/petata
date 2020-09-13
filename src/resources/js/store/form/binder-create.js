/**
 * フォームデータストア - バインダー作成 / 編集
 */
import { STATUS, MESSAGE, MESSAGE_TYPE } from "../../const";
import { util } from '../../util'
import Vue from "vue";

const state = {
    /**
     * APIの実行結果
     * true: 成功
     * false: 失敗
     */
    apiStatus: null,
    /**
     * id: Number バインダーID
     * name: String バインダー名
     * description: String バインダーの説明
     * labels: Array ラベルの配列
     *   - name: String ラベル名
     *   - description: String ラベルの説明
     */
    form: {
        id: 0,
        name: "",
        description: "",
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
    setForm(state, val) {
        state.form = val;
    },
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
    },
    setApiStatus(state, val) {
        state.apiStatus = val;
    }
};

const getters = {
    /**
     * バインダーが新規登録かどうかを判定します。
     */
    isNewBinder(context) {
        const newBinderId = 0;
        return state.form.id == newBinderId;
    }
};

const actions = {
    async doPost(context) {
        context.commit("setApiStatus", null);

        const uri = "api/binder/save";
        const response = await axios
            .post(`${uri}`, state.form)
            .catch(err => err.response || err);

        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
            context.commit("setApiStatus", true);
            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            console.log(response.data.errors);
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            const message = util.createMessage(MESSAGE.BINDER_CREATE.FAIL, MESSAGE_TYPE.ERROR);
            context.dispatch("messageBox/add", message, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            const message = util.createMessage(MESSAGE.COMMON.SYSTEM_ERROR, MESSAGE_TYPE.ERROR);
            context.dispatch("messageBox/add", message, {
                root: true
            });
        }
    },
    /**
     * フォームを初期化します。
     */
    clear() {
        const defaultForm = {
            id: 0,
            name: "",
            description: "",
            labels: []
        };

        state.form = defaultForm;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
    actions
};
