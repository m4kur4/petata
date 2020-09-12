/**
 * 認証関係ストア
 */
import { STATUS, MESSAGE } from "../../const";

const state = {
    /**
     * APIの実行結果
     * true: 成功
     * false: 失敗
     */
    apiStatus: null,
    /**
     * ログイン中のユーザー
     */
    user: null,
    /**
     * ユーザー認証に関するAPIのエラーメッセージ
     */
    errorMessages: null,
    /**
     * 継続ログインの有無
     */
    isEnabledAutoLogin: false
};

const getters = {
    /**
     * ユーザーのログイン状態をチェックする
     */
    check: state => !!state.user,
    /**
     * ログイン中のユーザー名を取得する
     */
    username: state => (state.user ? state.user.name : "")
};

const mutations = {
    setUser(state, user) {
        state.user = user;
    },
    setApiStatus(state, status) {
        state.apiStatus = status;
    },
    setErrorMessages(state, messages) {
        state.apiStatus = messages;
    },
    setIsEnableAutoLogin(state, val) {
        state.isEnabledAutoLogin = val;
    }
};

const actions = {
    /**
     * ユーザー登録
     * @param {obj} フォームデータ
     */
    async register(context, data) {
        const uri = "api/user/register";

        // API呼び出し
        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`, data)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.CREATED) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);
            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            context.dispatch("messageBox/add", MESSAGE.SIGNUP.FAIL, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            context.dispatch("messageBox/add", MESSAGE.COMMON.SYSTEM_ERROR, {
                root: true
            });
        }
    },
    /**
     * ユーザー認証
     * @param {obj} フォームデータ
     */
    async login(context, data) {
        const uri = "api/user/auth/login";

        // API呼び出し
        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`, data)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);
            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            context.dispatch("messageBox/add", MESSAGE.SIGNIN.FAIL, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            context.dispatch("messageBox/add", MESSAGE.COMMON.SYSTEM_ERROR, {
                root: true
            });
        }
    },
    /**
     * ログアウト
     */
    async logout(context) {
        const param = {
            data: {},
            uri: "api/user/auth/logout",
            fnSuccess: response => {
                context.commit("setApiStatus", true);
                context.commit("setUser", null);
                return false;
            }
        };
        await context.dispatch("callApi", param);
    },
    /**
     * 認証API呼び出しの基底処理
     * @param {obj} param
     * {
     *   'data': フォームデータ,
     *   'uri': APIのURI,
     *   'fnSuccess': APIが正常に実行された際の処理
     * }
     */
    async callApi(context, param) {
        // パラメタの展開
        const data = param["data"];
        const uri = param["uri"];
        const fnSuccess = param["fnSuccess"];
    },
    /**
     * ログインユーザーの情報を取得します。
     * ログインセッションが存在する場合はstateへユーザー情報を設定します。
     *
     * NOTE: ページをリロードするとstoreが初期化されてログイン状態が保持できないため
     */
    async getUserInfo(context) {
        const response = await axios.get("api/user/info");

        const userInfo = response.data;
        console.log(response);
        if (response.data == "") {
            // 未ログイン時はnullを設定
            context.commit("setUser", null);
        } else {
            context.commit("setUser", userInfo);
        }
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
