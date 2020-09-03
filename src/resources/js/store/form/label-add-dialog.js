/**
 * ラベル追加ダイアログフォームストア
 */
const state = {
    /**
     * 追加/編集
     */
    mode: "Add",
    index: null,
    id: 0,
    name: '',
    description: '',
};

const mutations = {
    setMode(state, val) {
        state.mode = val;
    },
    setIndex(state, val) {
        state.index = val;
    },
    setId(state, val) {
        state.id = val;
    },
    setName(state, val) {
        state.name = val;
    },
    setDescription(state, val) {
        state.description = val;
    },
};

const actions = {
    clear() {
        state.mode = "Add";
        state.index = null;
        state.id = 0;
        state.name = '';
        state.description = '';
    },
};

export default {
    namespaced: true,
    state,
    actions,
    mutations
};
