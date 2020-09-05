/**
 * フォームデータストア - バインダー
 */
import { STATUS } from "../../const";
import Vue from 'vue';

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
     *   [
     *   - id: Number ラベルID
     *   - name: String ラベル名
     *   - description:  ラベルの説明
     *   ]..
     * images: Array 画像
     *   [
     *   - id: Number 画像ID
     *   - name: String 画像名
     *   - description:  画像の説明
     *   - url: String URL
     *   ]..
     * search_condition: Object 画像の絞り込み条件
     *   - binder_id: Number バインダーID
     *   - image_name: String 画像名
     *   - label_ids: Array(Number) ラベルID
     * dragging_image_labeling_Label_ids: Array ドラッグ中の画像にラベリングされているラベルID
     * is_dragging_image Boolean バインダー画像をドラッグ中かどうか
     */
    id: null,
    name: null,
    description: null,
    count_user: 0,
    count_image: 0,
    count_label: 0,
    count_favorite: 0,
    labels: [],
    images: [],
    search_condition: {
        binder_id: null,
        image_name: "",
        label_ids: []
    },
    dragging_image_labeling_label_ids: [],
    is_dragging_image: false
};

const mutations = {
    setId(state, val) {
        state.id = val;
        state.search_condition.binder_id = val;
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
    },
    setSearchCondition(state, val) {
        state.search_condition = val;
    },
    setSearchConditionImage(state, val) {
        state.search_condition.image_name = val;
    },
    setSearchConditionLabel(state, val) {
        // すでにラベルIDが設定済みの場合は除去する
        const isAlreadyExist = state.search_condition.label_ids.includes(val);
        if (isAlreadyExist) {
            state.search_condition.label_ids = state.search_condition.label_ids.filter(
                id => {
                    return id !== val;
                }
            );
        } else {
            state.search_condition.label_ids.push(val);
        }
    },
    setDraggingImageLabelingLabelIds(state, val) {
        state.dragging_image_labeling_label_ids = val;
    },
    setIsDraggingImage(state, val) {
        state.is_dragging_image = val;
    },
};

const getters = {
    /**
     * 指定したラベルIDがstateの検索条件へ追加されているかどうかを判定します。
     */
    isAlreadyAddSearchConditionLabel: state => labelId => {
        return state.search_condition.label_ids.includes(labelId);
    },
    /**
     * 指定したラベルIDがドラッグ中の画像にラベリングされているかを確認します。
     */
    isLabelingWithDraggingImageLabel: state => labelId => {
        return state.dragging_image_labeling_label_ids.includes(labelId);
    },
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
        context.commit("setSearchCondition", {
            binder_id: null,
            image_name: "",
            label_ids: []
        });
    },
    /**
     * ラベル情報をDBへ保存します。
     */
    async saveLabel(context, postData) {
        const uri = "api/binder/label/save";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (
            response.status === STATUS.OK ||
            response.status === STATUS.CREATED
        ) {
            console.log(response.data);
            context.commit("setLabels", response.data.labels);
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
    },
    /**
     * ラベリングを行います。
     */
    async labeling(context, postData) {
        const uri = "api/binder/label/register";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.CREATED) {
            // ラベリングを登録した場合
            alert("ラベリングに成功しました。");
            return false;
        } else if (response.status === STATUS.OK) {
            // ラベリングを登録解除した場合
            alert("登録解除しました。");
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
    },
    /**
     * stateに保持している条件で画像を検索します。
     */
    async searchBinderImage(context) {
        const uri = "api/binder/image/search";
        const response = await axios
            .get(`${uri}`, { params: state.search_condition })
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setImages", response.data);
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
    },
    /**
     * ラベルを削除します。
     */
    async removeLabel(context, label) {
        label.binder_id = state.id;
        
        const uri = "api/binder/label/delete";
        const response = await axios
            .post(`${uri}`, label)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setLabels", response.data);
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
    },
    /**
     * 画像を削除します。
     */
    async removeImage(context, imageIds) {

        const postData = {
            binder_id: state.id,
            image_ids: imageIds
        };

        const uri = "api/binder/image/delete";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.dispatch("searchBinderImage");
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
    },
    /**
     * 指定したインデックス番号の画像情報をサーバーから再取得します。
     * NOTE: ラベリング状態やファイル名変更の反映
     */
    async fetchImage(context, index) {

        const imageId = state.images[index].id;
        const uri = `api/binder/image/detail/${imageId}`;

        const response = await axios
            .get(`${uri}`, { params: state.search_condition })
            .catch(err => err.response || err);
        
        const image = response.data.image;
        Vue.set(state.images, index, image);
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
