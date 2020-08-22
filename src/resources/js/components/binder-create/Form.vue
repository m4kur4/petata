<template>
    <div
        :class="['form--binder-create', { 'filtered-for-modal': isShowDialog }]"
    >
        <FormTitle :clazz="'form__title'">
            <template v-slot:title>Create binder</template>
        </FormTitle>
        <div class="form__wrapper--create-binder-left">
            <TextForm
                v-model="binderName"
                :title="'Binder name*'"
                :type="'text'"
                :placeholder="'ぺた太のアートワーク'"
            />
            <TextAreaForm
                v-model="binderDescription"
                :title="'Description'"
                :placeholder="'バインダーの説明を入力します。'"
            />
            <button @click="doPost" type="button" class="form__button--submit">
                Create
            </button>
        </div>
        <div class="form__wrapper--create-binder-right">
            <label class="form__label">Labels</label>
            <div @click="openDialog" class="form__button--add-label">
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
                <LabelContainer :labels="labels" />
            </div>
        </div>
    </div>
</template>

<script>
import FormTitle from "../common/FormTitle.vue";
import LabelContainer from "../common/LabelContainer.vue";
import TextForm from "../common/TextForm.vue";
import TextAreaForm from "../common/TextAreaForm.vue";

export default {
    components: {
        FormTitle,
        LabelContainer,
        TextForm,
        TextAreaForm
    },
    methods: {
        openDialog() {
            this.$store.commit("mode/setIsShowDialog", true);
        },
        closeDialog() {
            this.$store.commit("mode/setIsShowDialog", false);
        },
        async doPost() {
            await this.$store.dispatch("binderCreate/doPost");
        }
    },
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
        binderName: {
            get() {
                return this.$store.state.binderCreate.binderName;
            },
            set(val) {
                this.$store.commit("binderCreate/setBinderName", val);
            }
        },
        binderDescription: {
            get() {
                return this.$store.state.binderCreate.binderDescription;
            },
            set(val) {
                this.$store.commit("binderCreate/setBinderDescription", val);
            }
        },
        labels: {
            get() {
                return this.$store.state.binderCreate.labels;
            }
        }
    }
};
</script>
