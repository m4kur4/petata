/**
 * 画面モードストア
 */
const state = {
    /**
     * ナビゲーションバーの有無
     */
    hasNavigation: false,
    /**
     * ダイアログ表示の有無
     */
    isShowDialog: false
};

const mutations = {
    setHasNavigation(state, val) {
        state.hasNavigation = val;
    },
    setIsShowDialog(state, val) {
        state.isShowDialog = val;
    }
};

export default {
    namespaced: true,
    state,
    mutations
};
