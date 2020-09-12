/**
 * APIエラーストア
 */
const state = {
    code: null,
    messages: {}
};

const mutations = {
    setCode(state, code) {
        state.code = code;
    },
    setMessages(state, val) {
        state.messages = val;
    },
};

const actions = {
    clearMessages(context) {
        state.messages = {};
    }
}

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
