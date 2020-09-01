/**
 * ラベル追加ダイアログフォームストア
 */
const state = {
    id: 0,
    name: '',
    description: '',
};

const mutations = {
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
