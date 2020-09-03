export const util = {
    /**
     * 指定した画像をクリップボードにコピーします。
     */
    async copyImageToClipBoard(image) {
        const img = await fetch(image.src);
        const imgBlob = await img.blob();
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
};
