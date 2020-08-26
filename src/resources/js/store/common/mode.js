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
    isShowDialog: false,
    /**
     * ローディング画像の有無
     */
    isLoading: false
};

const mutations = {
    setHasNavigation(state, val) {
        state.hasNavigation = val;
    },
    setIsShowDialog(state, val) {
        state.isShowDialog = val;
    },
    setIsLoading(state, val) {
        state.isLoading = val;
    }
};

export default {
    namespaced: true,
    state,
    mutations
};
