<template>
<div v-if="isShowDialog" class="form--add-label-dialog">
    <div class="form__header--add-label-dialog mdc-elevation--z1">
        <span>Add label</span>
        <button @click="closeDialog">×</button>
    </div>
    <div class="form__wrapper--add-label-dialog">
        <label class="form__label"
            >Label name*
            <span class="form__error-message"
                >ラベル名は必須です。</span
            >
        </label>
        <input
            type="text"
            class="form__text"
            placeholder="ぺた太のお気に入り"
        />
        <label class="form__label"
            >Description
            <span class="form__error-message"></span>
        </label>
        <textarea
            class="form__text-area"
            cols="50"
            rows="8"
            wrap="soft"
            placeholder="ラベルの説明を入力します。"
        ></textarea>
        <button @click="applyToForm" type="button" class="form__button--submit">
            Add
        </button>
    </div>
</div>

</template>

<script>
export default {
    props: {
        name: String,
        description: String
    },
    methods: {
        /**
         * ダイアログを閉じます。
         */
        closeDialog() {
            this.$store.commit('mode/setIsShowDialog', false)
        },
        /**
         * ダイアログの入力値を呼び出し元画面へｈ反映します。
         */
        applyToForm() {
            // TODO: 実装
            const formData = {
                name: this.name,
                description: this.description
            };
            //this.$emit('add-label', formData);
        }
    },
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
    },
};
</script>
