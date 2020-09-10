/**
 * フォームデータストア - バインダー
 */
import { STATUS, SAVE_ORDER_TYPE } from "../../const";

import Vue from "vue";

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
     * is_draggable_processing Boolean Draggableの操作中かどうか
     * focused_image_id Number フォーカスされている画像のID
     * created_at Date バインダー作成日
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
    is_dragging_image: false,
    is_draggable_processing: false,
    focused_image_id: null,
    created_at: null
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
    setSearchConditionImageName(state, val) {
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
    setIsDraggableProcessing(state, val) {
        state.is_draggable_processing = val;
    },
    setFocusedImageId(state, val) {
        state.focused_image_id = val;
        // 2秒でフォーカスを解除
        setTimeout(() => {
            if (state.focused_image_id == val) {
                state.focused_image_id = null;
            }
        }, 2000);
    },
    setCreatedAt(state, val) {
        state.created_at = val;
    },
};

const getters = {
    /**
     * 指定したラベルIDがstateの検索条件へ追加されているかどうかを判定します。
     *
     * @param {int} labelId ラベルID
     */
    isAlreadyAddSearchConditionLabel: state => labelId => {
        return state.search_condition.label_ids.includes(labelId);
    },
    /**
     * 指定したラベルIDがドラッグ中の画像にラベリングされているかを確認します。
     *
     * @param {int} labelId ラベルID
     */
    isLabelingWithDraggingImageLabel: state => labelId => {
        return state.dragging_image_labeling_label_ids.includes(labelId);
    },
    /**
     * 指定した画像IDがフォーカス中の画像のものかどうかを判定します。
     */
    isFocusedImageId: state => imageId => {
        return state.focused_image_id == imageId;
    },
    /**
     * Draggableによる「画像/ラベル」(以下「対象」)の並び順を永続化するリクエスト用のデータを取得します。
     * 対象の並び順が変わらない場合はnullを返却します。
     * 
     * NOTE: 更新後の並び順 算出仕様
     * 対象が前方に移動した場合、「指定した対象のひとつ後ろに位置する対象が持つ並び順」
     * それ以外の場合は「指定した対象のひとつ前に位置する対象が持つ並び順」を設定する
     *
     * @param {Object} param
     *   - target_id : 対象のID
     *   - org_index : 移動前のインデックス 
     *   - save_order_type : 対象の種類(util.js > SAVE_ORDER_TYPE)
     * @return {Object} 
     *   - binder_id : バインダーID
     *   - target_id : 対象のID
     *   - sort_after : 更新後の並び順
     */
    getDataForSaveOrderState: state => param => {

        // 並び順更新種別に応じて参照するstateを変更
        let refs = [];
        if (param.save_order_type == SAVE_ORDER_TYPE.IMAGE) {
            refs = state.images;
        } else if (param.save_order_type == SAVE_ORDER_TYPE.LABEL) {
            refs = state.labels;
        }

        // 並び順が変更されているかどうか
        let isChanged = false;

        // 更新後の並び順を持っている画像のインデックス
        let refIndex; 

        const targetId = param.target_id;

        const target = refs.find((ref, index) => {
            // 並び順更新対象かどうか
            const isTarget = ref.id == targetId;

            if (isTarget) {
                
                isChanged = index != param.org_index;
                if (!isChanged) {
                    // 並び順が変わっていない場合は後続処理なし
                    return isTarget;
                }

                // 移動方向が前方かどうか
                const isForwardUpdate = index < param.org_index;
                
                if (isForwardUpdate) {
                    // 前方移動の場合
                    if (index == 0) {
                        // 先頭へ移動した場合は2番目の画像を参照
                        refIndex = 1;
                    } else {
                        // それ以外の場合は1つ後ろの画像を参照
                        refIndex = index + 1;
                    }
                } else {
                    // 後方移動の場合
                    const lastIndex = refs.length - 1;
                    if (index == lastIndex) {
                        // 最後尾へ移動した場合は後ろから2番目の画像を参照
                        refIndex = lastIndex - 1;
                    } else {
                        // それ以外の場合は1つ前の画像を参照
                        refIndex = index - 1;
                    }
                }
            }
            return isTarget;
        });

        if (!isChanged) {
            // 並び順が変わっていない場合はnullを返却
            return null;
        }

        // 更新後の並び順を取得
        const sortAfter = refs[refIndex].sort;

        const postData = {
            binder_id: state.id,
            target_id: targetId,
            sort_after: sortAfter 
        };
        console.log("[DEBUG]" + target.sort + " => " + postData.sort_after);

        return postData;
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
            context.commit("setCreatedAt", response.data.created_at);
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
        context.commit("setCreatedAt", null);
    },
    /**
     * ラベル情報をDBへ保存します。
     */
    async saveLabel(context, postData) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

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

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * ラベリングを行います。
     */
    async labeling(context, postData) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);
        
        const uri = "api/binder/label/register";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.CREATED) {
            // ラベリングを登録した場合

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
            return false;

        } else if (response.status === STATUS.OK) {
            // ラベリングを登録解除した場合

            // 解除したあとの条件で再検索
            context.dispatch("searchBinderImage");

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * stateに保持している条件で画像を検索します。
     */
    async searchBinderImage(context) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        const uri = "api/binder/image/search";
        const response = await axios
            .get(`${uri}`, { params: state.search_condition })
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            context.commit("setImages", response.data);
            
            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);

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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * ラベルを削除します。
     */
    async removeLabel(context, label) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);
        
        label.binder_id = state.id;

        const uri = "api/binder/label/delete";
        const response = await axios
            .post(`${uri}`, label)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            // ラベル情報を再取得
            state.labels = response.data;

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
            
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 画像を削除します。
     */
    async removeImage(context, imageIds) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

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

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 画像のファイル名を更新します。
     */
    async updateImageName(context, image) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        image.binder_id = state.id;

        const uri = "api/binder/image/rename";
        const response = await axios
            .post(`${uri}`, image)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            // TODO: リネームに成功した旨をメッセージ

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 画像の並べ替え状態を永続化します。
     */
    async saveImageOrderState(context, postData) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);
        
        console.log(postData);
        const uri = "api/binder/image/sort";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /** 
     * ラベルの並べ替え状態を永続化します。
     */
    async saveLabelOrderState(context, postData) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        console.log(postData);
        const uri = "api/binder/label/sort";
        const response = await axios
            .post(`${uri}`, postData)
            .catch(err => err.response || err);

        // 成功
        if (response.status === STATUS.OK) {
            state.labels = response.data.labels;

            // 通信完了
            context.dispatch("setProgressIndicatorVisibleState", false);
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
        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 指定したインデックス番号の画像情報をサーバーから再取得します。
     * NOTE: ラベリング状態やファイル名変更の反映
     */
    async fetchImage(context, index) {

        // 通信開始
        context.dispatch("setProgressIndicatorVisibleState", true);

        const imageId = state.images[index].id;
        const uri = `api/binder/image/detail/${imageId}`;

        const response = await axios
            .get(`${uri}`, { params: state.search_condition })
            .catch(err => err.response || err);

        const image = response.data.image;
        Vue.set(state.images, index, image);

        // 通信完了
        context.dispatch("setProgressIndicatorVisibleState", false);
    },
    /**
     * 通信中であることを示すプログレスインジケーターの表示状態を設定します。
     */
    async setProgressIndicatorVisibleState(context, val) {
        context.commit('mode/setIsConnecting', val, { root: true }) ;
    }
};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
};
