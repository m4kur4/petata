<template>
    <div class="form--binder-create">
        <FormTitle :clazz="'form__title'">Create binder</FormTitle>
        <div class="form__wrapper--create-binder-left">
            <label class="form__label"
                >Binder name*
                <span class="form__error-message"
                    >バインダー名は必須です。</span
                >
            </label>
            <input
                type="text"
                class="form__text"
                placeholder="ぺた太のアートワーク"
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
                placeholder="バインダーの説明を入力します。"
            ></textarea>
            <button type="button" class="form__button--submit">
                Create
            </button>
        </div>
        <div class="form__wrapper--create-binder-right">
            <label class="form__label">Labels</label>
            <div class="form__button--add-label">
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
                <div class="label-container">
                    <div class="label-container__item mdc-elevation--z2">
                        <p class="label-container__item-title">ラベル名</p>
                        <p class="label-container__item-description">
                            ラベルの説明<br />
                            ラベルの説明<br />
                        </p>
                    </div>
                    <div class="label-container__item mdc-elevation--z2">
                        <p class="label-container__item-title">ラベル名</p>
                        <p class="label-container__item-description">
                            ラベルの説明<br />
                            ラベルの説明<br />
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="form__link">Sign up</a>
    </div>
</template>

<script>
import FormTitle from "../common/FormTitle.vue";

export default {
    components: {
        FormTitle
    },
    data() {
        return {
            form: {
                binder_name: "",
                description: "",
                label_names: [],
                label_descriptions: [],
            }
        };
    }
};
</script>
