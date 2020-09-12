/**
 * 認証関係ストア
 */
import { STATUS } from "../../const";

const state = {
    /**
     * ログイン中のユーザー
     */
    user: null,
    /**
     * ユーザー認証に関するAPIの実行結果
     * true: 成功
     * false: 失敗
     */
    apiStatus: null,
    /**
     * ユーザー認証に関するAPIのエラーメッセージ
     */
    errorMessages: null,
    /**
     * 継続ログインの有無
     */
    isEnabledAutoLogin: false,
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
        const param = {
            data: data,
            uri: "api/user/register",
            fnSuccess: response => {
                context.commit("setApiStatus", true);
                context.commit("setUser", response.data);
                return false;
            }
        };
        await context.dispatch("callApi", param);
    },
    /**
     * ユーザー認証
     * @param {obj} フォームデータ
     */
    async login(context, data) {
        const param = {
            data: data,
            uri: "api/user/auth/login",
            fnSuccess: response => {
                context.commit("setApiStatus", true);
                context.commit("setUser", response.data);
                return false;
            }
        };
        await context.dispatch("callApi", param);
    },
    /**
     * ログアウト
     */
    async logout(context) {
        const param = {
            data: {},
            uri: "api/user/auth/logout",
            fnSuccess: response => {
                context.commit('setApiStatus', true)
                context.commit('setUser', null)
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

        // API呼び出し
        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`, data)
            .catch(err => err.response || err);

        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
            return fnSuccess(response);
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, { root: true });

        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
        }
    },
    /**
     * ログインユーザーの情報を取得します。
     * ログインセッションが存在する場合はstateへユーザー情報を設定します。
     * 
     * NOTE: ページをリロードするとstoreが初期化されてログイン状態が保持できないため
     */
    async getUserInfo(context) {

        const response = await axios.get('api/user/info');
        
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
