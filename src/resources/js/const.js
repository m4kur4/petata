export const STATUS = {
    OK: 200,
    CREATED: 201,
    NO_CONTENT: 204,
    UNAUTHORIZED: 401,
    FORBIDDEN: 403,
    NOT_FOUND: 404,
    UNPROCESSABLE_ENTITY: 422,
    INTERNAL_SERVER_ERROR: 500
};

export const BINDER_AUTHORITY_LEVEL = {
    GUEST: 0,
    MAINTAINER: 10,
    OWNER: 50
};

export const SAVE_ORDER_TYPE = { // バインダー画面の並べ替え更新種別
    IMAGE: 10, // 画像
    LABEL: 20, // ラベル
}

export const TRANSITION_TYPE = {// トランジションの種類(src\resources\sass\common\_base.scss)
    FADE: 'fade',
    FADE_FASTER: 'page-out',
    PAGE_IN: 'page-in',
    PAGE_OUT: 'page-out',
}

export const MESSAGE_TYPE = {
    ERROR: 'error',
    SUCCESS: 'success',
};

export const SCREEN_MODE = {// 画面モード
    BINDER: {
        NORMAL: 'normal',
        DELETE: 'delete',
        LABELING: 'labeling',
    },
};

export const MESSAGE = {
    COMMON: {
        SYSTEM_ERROR: "システムエラーが発生しました。",
    },
    SIGNIN: {
        ERROR: "ログインに失敗しました。",
        NOTIFY: "メールアドレスまたはパスワードが正しくありません。",
        SUCCESS: "サインインしました。",
    },
    SIGNUP: {
        ERROR: "入力内容をご確認ください。",
        SUCCESS: "ユーザーを登録しました。",
    },
    SIGNOUT: {
        ERROR: "サインアウトに失敗しました。",
        SUCCESS: "サインアウトしました。",
    },
    BINDER_CREATE: {
        ERROR: "入力内容をご確認ください。",
        SUCCESS: "保存しました。",
    },
    BINDER_LIST: {
        SUCCESS: {
            DELETE_BINDER: "バインダーを削除しました。",
        }
    },
    LABEL_ADD_DLG: {
        ERROR: "入力内容をご確認ください。",
        NOTIFY: {
            NAME:{
                REQUIRED: "ラベル名は必須です。",
                MAX: "ラベル名は20字以内で設定してください。",
            }
        }
    },
    BINDER: {
        IS_NOT_SELECT_IMAGES: "画像が選択されていません。",
        IS_NOT_SELECT_LABELS: "ラベルが選択されていません。",
        NOT_FOUND: "存在しないバインダーです。", 
        SUCCESS: {
            ADD_IMAGE: "アップロードしました。",
            DELETE_IMAGE: "削除しました。",
            ADD_LABEL: "保存しました。",
            DELETE_LABEL: "削除しました。",
            ADD_LABELING: "登録しました。",
            DELETE_LABELING: "登録を解除しました。",
            SET_LABELING: "設定しました。",
        },
    },
};