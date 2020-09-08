<template>
    <transition name="fade-faster">
        <div v-if="isShowDialog" class="form--add-label-dialog">
            <div class="form__header--add-label-dialog mdc-elevation--z1">
                <span>{{ mode }} label</span>
                <button @click="closeDialog">×</button>
            </div>

            <div class="form__wrapper--add-label-dialog">
                <TextForm
                    v-model="name"
                    :title="'Label name*'"
                    :type="'text'"
                    :placeholder="'ぺた太のお気に入り'"
                    :value="name"
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
                    {{ mode }}
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
import TextForm from "./TextForm.vue";
import TextAreaForm from "./TextAreaForm.vue";

export default {
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
            this.$store.dispatch("labelAddDialog/clear");
        },
        /**
         * ダイアログの入力値を親画面へ受け渡します。
         * カスタムイベント名："add-label-click"
         */
        add() {
            // TODO: 実装
            const formData = {
                index: this.index,
                id: this.id,
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
        },
        mode() {
            return this.$store.state.labelAddDialog.mode;
        },
        index: {
            get() {
                return this.$store.state.labelAddDialog.index;
            }
        },
        id: {
            get() {
                return this.$store.state.labelAddDialog.id;
            }
        },
        name: {
            get() {
                return this.$store.state.labelAddDialog.name;
            },
            set(value) {
                this.$store.commit("labelAddDialog/setName", value);
            }
        },
        description: {
            get() {
                return this.$store.state.labelAddDialog.description;
            },
            set(value) {
                this.$store.commit("labelAddDialog/setDescription", value);
            }
        }
    }
};
</script>
