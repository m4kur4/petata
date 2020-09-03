/**
 * ラベル追加ダイアログフォームストア
 */
const state = {
    /**
     * 追加/編集
     */
    mode: "Add",
    id: 0,
    name: '',
    description: '',
};

const mutations = {
    setMode(state, val) {
        state.mode = val;
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
