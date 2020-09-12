<template>
    <div
        :class="['form--binder-create', { 'filtered-for-modal': isShowDialog }]"
    >
        <FormTitle :clazz="'form__title--binder-create'">
            <template v-slot:title
                >{{ isNewBinder ? "Create" : "Edit" }} binder</template
            >
            <template v-slot:additional-content>
                <BinderListButton />
            </template>
        </FormTitle>
        <div class="form__wrapper--create-binder-left">
            <TextForm
                v-model="binderName"
                :title="'Binder name*'"
                :type="'text'"
                :placeholder="'ぺた太のアートワーク'"
                :value="''"
                :errors="errors.name"
            />
            <TextAreaForm
                v-model="binderDescription"
                :title="'Description'"
                :placeholder="'バインダーの説明を入力します。'"
                :value="''"
                :errors="errors.description"
            />
            <button @click="doPost" type="button" class="form__button--submit">
                {{ isNewBinder ? "Create" : "Edit" }}
            </button>
        </div>
        <div class="form__wrapper--create-binder-right">
            <label class="form__label">Labels</label>
            <div
                @click="openDialog"
                　
                v-tooltip.top-end="{
                    content: 'ラベルを追加します。'
                }"
                class="form__button--add-label"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    height="56"
                    viewBox="0 0 24 24"
                    width="56"
                >
                    <path d="M0 0h24v24H0z" fill="none" />
                    <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z" />
                </svg>
            </div>
            <div class="form__label-list">
                <LabelContainer
                    @remove-label-click="removeLabel"
                    @label-state-change="saveLabelOrder"
                    :labels="labels"
                />
            </div>
        </div>
    </div>
</template>

<script>
import FormTitle from "../common/FormTitle.vue";
import LabelContainer from "../common/LabelContainer.vue";
import TextForm from "../common/TextForm.vue";
import TextAreaForm from "../common/TextAreaForm.vue";
import BinderListButton from "./BinderListButton.vue";
export default {
    components: {
        FormTitle,
        LabelContainer,
        TextForm,
        TextAreaForm,
        BinderListButton
    },
    methods: {
        /**
         * ラベル編集ダイアログを開きます。
         */
        openDialog() {
            this.$store.commit("mode/setIsShowDialog", true);
        },
        /**
         * ラベル編集ダイアログを閉じます。
         */
        closeDialog() {
            this.$store.commit("mode/setIsShowDialog", false);
            this.$store.dispatch("labelAddDialog/clear");
        },
        /**
         * バインダーを登録します。
         */
        async doPost() {
            await this.$store.dispatch("binderCreate/doPost");

            const isSuccess = this.apiStatus;
            if (isSuccess) {
                this.$router.push({ name: "binder-list" });
            }
        },
        /**
         * ラベルを削除します。
         */
        removeLabel(label) {
            this.$store.commit("binderCreate/removeLabel", label);
        },
        /**
         * ラベルの並び順変更をstateへ反映します。
         */
        saveLabelOrder(labels) {
            // NOTE: set()が呼びだされる
            this.labels = labels;
        }
    },
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
        binderName: {
            get() {
                return this.$store.state.binderCreate.form.name;
            },
            set(val) {
                this.$store.commit("binderCreate/setBinderName", val);
            }
        },
        binderDescription: {
            get() {
                return this.$store.state.binderCreate.form.description;
            },
            set(val) {
                this.$store.commit("binderCreate/setBinderDescription", val);
            }
        },
        labels: {
            get() {
                return this.$store.state.binderCreate.form.labels;
            },
            set(val) {
                this.$store.commit("binderCreate/setLabels", val);
            }
        },
        /**
         * バインダーが新規登録かどうかを判定します。
         * NOTE: ページタイトル・ボタンの文言を切り替えるため
         */
        isNewBinder() {
            return this.$store.getters["binderCreate/isNewBinder"];
        },
        /**
         * エラーメッセージ
         */
        errors() {
            return this.$store.state.error.messages;
        },
        /**
         * API実行結果
         */
        apiStatus() {
            return this.$store.state.apiStatus;
        }
    }
};
</script>
