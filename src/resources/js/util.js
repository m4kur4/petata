export const util = {
    /**
     * キャッシュ
     */
    cache: {
        image: {}
    },
    /**
     * 指定した画像をクリップボードにコピーします。
     */
    async copyImageToClipBoard(image, imageId) {
        const hasCache = !!util.cache.image[imageId];

        let imgBlob = null;
        if (hasCache) {
            // キャッシュがある場合
            imgBlob = util.cache.image[imageId];
        } else {
            // キャッシュがない場合は格納
            const img = await fetch(image.src, {
                mode: 'cors',
            });
            imgBlob = await img.blob();
            util.cache.image[imageId] = imgBlob;
        }

        try {
            navigator.clipboard.write([
                new ClipboardItem({
                    "image/png": imgBlob
                })
            ]);
        } catch (error) {
            console.error(error);
        }
    },
    /**
     * 指定したドラッグイベントがDraggableによるものかどうかを判定します。
     */
    isDraggableEvent(event) {
        return event.currentTarget.classList.contains("sortable-chosen");
    },
    /**
     * オブジェクトが空かどうかを判定します。
     * NOTE: 空 = {}
     */
    isEmptyObject(obj) {
        const len = Object.keys(obj).length;
        return len === 0;
    },
    /**
     * 通知メッセージを生成します。
     *
     * @param {String} val メッセージテキスト
     * @param {String} type メッセージのタイプ（成功/エラー）
     */
    createMessage(val, type) {
        return { val: val, type: type };
    },
    /**
     * Cookieから指定したキーの値を取得します。
     */
    getCookieValue(searchKey) {
        if (typeof searchKey === "undefined") {
            return "";
        }
        let val = "";

        document.cookie.split(";").forEach(cookie => {
            const [key, value] = cookie.split("=");
            if (key === searchKey) {
                return (val = value);
            }
        });
        return val;
    }
};
