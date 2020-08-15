/**
 * 画面モードストア
 */
const state = {
    /**
     * ナビゲーションバーの有無
     */
    hasNavigation: false
};

const mutations = {
    setHasNavigation(state, val) {
        state.hasNavigation = val;
    }
};

export default {
    namespaced: true,
    state,
    mutations
};
