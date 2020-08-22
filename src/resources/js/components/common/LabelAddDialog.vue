<template>
    <div v-if="isShowDialog" class="form--add-label-dialog">
        <div class="form__header--add-label-dialog mdc-elevation--z1">
            <span>Add label</span>
            <button @click="closeDialog">×</button>
        </div>

        <div class="form__wrapper--add-label-dialog">

            <TextForm
                v-model="name"
                :title="'Label name*'"
                :type="'text'"
                :placeholder="'ぺた太のお気に入り'"
            />

            <label class="form__label"
                >Description
                <span class="form__error-message"></span>
            </label>
            <textarea
                v-model="description"
                class="form__text-area"
                cols="50"
                rows="8"
                wrap="soft"
                placeholder="ラベルの説明を入力します。"
            ></textarea>

            <button @click="add" type="button" class="form__button--submit">
                Add
            </button>
        </div>
    </div>
</template>

<script>
import TextForm from "./TextForm.vue";
import TextAreaForm from "./TextAreaForm.vue";

export default {
    data() {
        return {
            name: null,
            description: null
        };
    },
    components: {
        TextForm,
        TextAreaForm
    },
    methods: {
        /**
         * ダイアログを閉じます。
         */
        closeDialog() {
            this.name = null;
            this.description = null;
            this.$store.commit("mode/setIsShowDialog", false);
        },
        /**
         * ダイアログの入力値を親画面へ受け渡します。
         * カスタムイベント名："add-label-click"
         */
        add() {
            // TODO: 実装
            const formData = {
                name: this.name,
                description: this.description
            };
            // NOTE: 処理を親へ委譲することで画面ごとに振る舞いを変える
            this.$emit("add-label-click", formData);
            this.closeDialog();
        }
    },
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        }
    }
};
</script>
