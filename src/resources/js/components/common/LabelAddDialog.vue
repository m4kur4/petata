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
                    :errors="errors"
                />

                <TextAreaForm
                    v-model="description"
                    :title="'Description'"
                    :placeholder="'ラベルの説明を入力します。'"
                    :value="''"
                    :errors="errors.description"
                />

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
import { MESSAGE, MESSAGE_TYPE } from "../../const";
import { util } from "../../util";

export default {
    components: {
        TextForm,
        TextAreaForm
    },
    data() {
        return {
            errors: []
        };
    },
    methods: {
        /**
         * ダイアログを閉じます。
         */
        closeDialog() {
            this.name = null;
            this.description = null;
            this.errors = [];
            this.$store.commit("mode/setIsShowDialog", false);
            this.$store.dispatch("labelAddDialog/clear");
        },
        /**
         * ダイアログの入力値を親画面へ受け渡します。
         * カスタムイベント名："add-label-click"
         */
        add() {
            const isValid = this.validate();
            if (!isValid) {
                // 入力値が不正な場合は後続処理なし
                return false;
            }

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
        },
        /**
         * 入力値を検証します。
         * NOTE: 直接ダイアログからサーバーへ送信しない場合があるため
         */
        validate() {
            // 初期化
            this.errors = [];
            // 名前は必須
            if (!!!this.name) {
                this.errors.push(MESSAGE.LABEL_ADD_DLG.NOTIFY.NAME.REQUIRED);
            }
            // 名前は20字以内
            if (this.name.length > 20) {
                this.errors.push(MESSAGE.LABEL_ADD_DLG.NOTIFY.NAME.MAX);
            }
            if (this.errors.length > 0) {
                const message = util.createMessage(
                    MESSAGE.LABEL_ADD_DLG.ERROR,
                    MESSAGE_TYPE.ERROR
                );
                this.$store.dispatch("messageBox/add", message);
                return false;
            }
            return true;
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
