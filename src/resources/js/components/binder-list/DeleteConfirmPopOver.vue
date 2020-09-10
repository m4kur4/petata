<template>
    <transition name="fade">
        <div class="remove-binder-popover__content">
            <div class="remove-binder-popover__header mdc-elevation--z1">
                <span class="remove-binder-popover__header-text">
                    Confirm
                </span>
            </div>
            <div class="remove-binder-popover__content">
                <span class="remove-binder-popover__message"
                    >以下のバインダーを削除します。</span
                >
                <div class="remove-binder-popover__binder-name">
                    {{ binderName }}
                </div>
                <span class="remove-binder-popover__description"
                    >確認のため、バインダー名を入力してください。</span
                >
                <input
                    @keyup="checkIsSetBinderName"
                    ref="binderNameTextForm"
                    class="remove-binder-popover__textform"
                    type="text"
                    :placeholder="binderName"
                />
                <div class="remove-binder-popover__button-wrapper">
                    <button
                    @click="deleteBinder"
                        v-close-popover
                        :class="[
                            'remove-binder-popover__button-ok',
                            {
                                disabled: !isSetBinderName
                            }
                        ]"
                        :disabled="!isSetBinderName"
                        type="button"
                    >
                        Delete
                    </button>
                    <button
                        v-close-popover
                        class="remove-binder-popover__button-no"
                        type="button"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            isSetBinderName: false
        };
    },
    props: {
        binderId: Number,
        binderName: String
    },
    methods: {
        /**
         * 削除対象のバインダー名がテキストフォームに設定されているかどうかを判定します。
         */
        checkIsSetBinderName() {
            const input = this.$refs.binderNameTextForm.value;
            this.isSetBinderName = input == this.binderName;
        },
        /**
         * バインダーの削除を実行します。
         */
        deleteBinder() {
            if (!this.isSetBinderName) {
                return false;
            }
            this.$store.dispatch("binderList/deleteBinder", this.binderId);
        }
    }
};
</script>
