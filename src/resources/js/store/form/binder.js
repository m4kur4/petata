/**
 * フォームデータストア - バインダー
 */
import { STATUS } from "../../const";

const state = {
    /**
     * id: String バインダーID
     * name: String バインダー名
     * description: String バインダーの説明
     * count_user: Number 参加者数
     * count_image: Number 画像数
     * count_label: Number ラベル数
     * count_favorite: Number お気に入り登録数
     * labels: Array ラベル
     *   - id: Number ラベルID
     *   - name: String ラベル名
     *   - description:  ラベルの説明
     * images: Array 画像
     *   - id: Number 画像ID
     *   - name: String 画像名
     *   - description:  画像の説明
     *   - url: String URL
     */
    id: null,
    name: null,
    description: null,
    count_user: 0,
    count_image: 0,
    count_label: 0,
    count_favorite: 0,
    labels: [],
    images: []
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
    setCountUser(state, val) {
        state.count_user = val;
    },
    setCountImage(state, val) {
        state.count_image = val;
    },
    setCountLabel(state, val) {
        state.count_label = val;
    },
    setCountFavorite(state, val) {
        state.count_favorite = val;
    },
    setLabels(state, val) {
        state.labels = val;
    },
    setImages(state, val) {
        state.images = val;
    },
    addLabel(state, val) {
        state.labels.push(val);
    }
};

const actions = {
    /**
     * バインダー情報を取得します。
     */
    async fetchBinder(context, id) {
        // ローディング画像の表示
        context.commit("mode/setIsLoading", true, {
            root: true
        });
        const response = await axios.get(`api/binder/detail/${id}`);

        if (response.status === STATUS.OK) {
            context.commit("setId", response.data.id);
            context.commit("setName", response.data.name);
            context.commit("setDescription", response.data.description);
            context.commit("setCountUser", response.data.count_user);
            context.commit("setCountImage", response.data.count_image);
            context.commit("setCountLabel", response.data.count_label);
            context.commit("setCountFavorite", response.data.count_favorite);
            context.commit("setLabels", response.data.labels);
            context.commit("setImages", response.data.images);
        } else {
            // 失敗時はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
                root: true
            });
        }
        // ローディング画像を非表示
        context.commit("mode/setIsLoading", false, {
            root: true
        });
    },
    /**
     * stateに保持しているバインダー情報を初期化します。
     */
    async clearBinder(context) {
        context.commit("setId", null);
        context.commit("setName", null);
        context.commit("setDescription", null);
        context.commit("setCountUser", 0);
        context.commit("setCountImage", 0);
        context.commit("setCountLabel", 0);
        context.commit("setCountFavorite", 0);
        context.commit("setLabels", []);
        context.commit("setImages", []);
    },
    /**
     * ラベル情報をDBへ保存します。
     */
    async saveLabel(context, labelData) {
        const uri = "api/binder/label/save";
        const response = await axios
            .post(`${uri}`, labelData)
            .catch(err => err.response || err);

        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
            console.log(response.data);
            context.commit("addLabel", response.data.label);
            return false;
        }

        // 失敗
        if (response.status === STATUS.UNPROCESSABLE_ENTITY) {
            // バリデーションエラーの場合はエラーメッセージを格納
            context.commit("setErrorMessages", response.data.errors);
        } else {
            // その他のエラーの場合はエラーコードを格納
            context.commit("error/setCode", response.data.status, {
                root: true
            });
        }
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions
};
