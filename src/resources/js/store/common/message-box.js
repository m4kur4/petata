/**
 * 通知メッセージストア
 */
import Vue from "vue";

const state = {
    messages: [],
    // メッセージを特定するためのキーとしてカウントアップする
    count: 0
};

const getters = {
    /**
     * 指定したメッセージが既に表示されているかを判定します。
     * NOTE: VueDropzoneのエラー時コールバックが
     * errormultipleを指定しているにもかかわらずファイルの数だけ走ってしまうため
     */
    exist: state => message => {
        const index = state.messages.findIndex(item => {
            return message.val == item.val;
        });
        return (-1) !== index;
    }
};

const mutations = {
    setMessages(state, val) {
        state.messages = val;
    },
    addMessage(state, message) {
        // 先頭に追加
        state.messages.unshift({
            count: state.count,
            val: message.val,
            type: message.type
        });
    },
    removeMessage(state, message) {
        // countで対象を特定し削除
        state.messages = state.messages.filter(item => {
            return item.count != message.count;
        });
    },
    countUp(state) {
        state.count++;
    }
};

const actions = {
    /**
     * メッセージを追加し、一定時間後に自動で消去します。
     */
    add(context, val) {
        const ttl = 3200;
        context.commit("addMessage", val);
        const message = state.messages[0];

        context.commit("countUp");
        setTimeout(() => {
            context.commit("removeMessage", message);
        }, ttl);
    },
    /**
     * 複数のメッセージを追加します。
     * NOTE: バインダー画面では通知メッセージでサーバーから返却されたエラーを表示するため
     */
    addMany(context, messages) {
        const messageCount = messages.length;
        for (let i = 0; i < messageCount; i++) {

            const message = messages[i];
            const isExist = context.getters["exist"](message);
            
            if (isExist) {
                // 同じメッセージが既に表示されている場合は追加しない
                continue;
            }
            context.dispatch("add", message);
        }
    },
    /**
     * メッセージをクリアします。
     */
    clear(context) {
        context.commit("setMessages", []);
    },

};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
