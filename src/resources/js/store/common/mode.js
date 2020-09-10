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
    isLoading: false,
    /**
     * ドロップゾーン表示の有無
     */
    isShowDropzone: false,
    /**
     * プログレスバー表示の有無
     */
    isConnecting: false
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
    },
    setIsShowDropzone(state, val) {
        state.isShowDropzone = val;
    },
    async setIsConnecting(state, val) {
        const func = () => {
            state.isConnecting = val;
        };
        if (val == false) {
            // 消す場合は最低1秒表示させる
            await setTimeout(func, 500);
            return false;
        }
        func();
    }
};

export default {
    namespaced: true,
    state,
    mutations
};
