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
    hasMessage(state) {
        // const count = state.messages.length;
        // return count > 0;
    }
};

const mutations = {
    setMessages(state, val) {
        state.messages = val;
    },
    addMessage(state, val) {
        // 先頭に追加
        state.messages.unshift({
            count: state.count,
            val: val
        });
    },
    removeMessage(state, message) {
        // countで対象を特定し削除
        state.messages = state.messages.filter(item => {
            return item.count != message.count
        });

    },
    countUp(state) {
        state.count++;
    },
};

const actions = {
    /**
     * メッセージを追加し、一定時間後に自動で消去します。
     */
    add(context, val) {
        const ttl = 4000;
        context.commit("addMessage", val);
        const message = state.messages[0];

        context.commit("countUp");
        setTimeout(() => {
            context.commit("removeMessage", message);
        }, ttl);
    },
    /**
     * メッセージをクリアします。
     */
    clear(context) {
        context.commit("setMessages", []);
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
