/**
 * 認証関係ストア
 */
import { STATUS, MESSAGE, MESSAGE_TYPE } from "../../const";
import { util } from "../../util";

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

            const message = util.createMessage(
                MESSAGE.SIGNUP.SUCCESS,
                MESSAGE_TYPE.SUCCESS
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });

            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.SIGNUP.ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.COMMON.SYSTEM_ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
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

            const message = util.createMessage(
                MESSAGE.SIGNIN.SUCCESS,
                MESSAGE_TYPE.SUCCESS
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });

            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.SIGNIN.ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.COMMON.SYSTEM_ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
        }
    },
    /**
     * ログアウト
     */
    async logout(context) {
        const uri = "api/user/auth/logout";

        // API呼び出し
        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);

            const message = util.createMessage(
                MESSAGE.SIGNOUT.SUCCESS,
                MESSAGE_TYPE.SUCCESS
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            const message = util.createMessage(
                MESSAGE.SIGNOUT.ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.COMMON.SYSTEM_ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
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
        const response = await axios.get("api/user/info");

        const userInfo = response.data;
        console.log(response);
        if (response.data == "") {
            // 未ログイン時はnullを設定
            context.commit("setUser", null);
        } else {
            context.commit("setUser", userInfo);
        }
    },
    /**
     * パスワードリマインダーメールを送信します。
     * NOTE: 送信の成否はユーザーへ通知しない
     */
    async sendPasswordReminderMail(context, address) {
        const postData = { email: address };
        const uri = "api/user/auth/reminder";

        // API呼び出し
        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        console.log(response.status);

        const message = util.createMessage(
            MESSAGE.PASSWORD_RESET.SEND_MAIL,
            MESSAGE_TYPE.SUCCESS
        );
        context.dispatch("messageBox/add", message, {
            root: true
        });

    },
    /**
     * パスワードのリセットを行います。
     */
    async resetPassword(context, postData) {
        const uri = "api/user/auth/password-reset";

        context.commit("setApiStatus", null);
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setApiStatus", true);
            context.commit("setUser", response.data);

            const message = util.createMessage(
                MESSAGE.PASSWORD_RESET.SUCCESS,
                MESSAGE_TYPE.SUCCESS
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });

            return false;
        }

        // 失敗
        context.commit("setApiStatus", false);
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("error/setMessages", response.data.errors, {
                root: true
            });
            const message = util.createMessage(
                MESSAGE.PASSWORD_RESET.ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.status, {
                root: true
            });
            console.log(response.status);
            const message = util.createMessage(
                MESSAGE.COMMON.SYSTEM_ERROR,
                MESSAGE_TYPE.ERROR
            );
            context.dispatch("messageBox/add", message, {
                root: true
            });
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
