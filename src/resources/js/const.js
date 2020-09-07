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