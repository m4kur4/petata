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
            const img = await fetch(image.src);
            imgBlob = await img.blob();
            util.cache.image[imageId] = imgBlob;
        }

        try {
           navigator.clipboard.write([
             new ClipboardItem({
                 'image/png': imgBlob,
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
    }
};
