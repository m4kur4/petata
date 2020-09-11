<template>
    <div>
        <button
            @click="moveToBinderCreate"
            v-tooltip.left="{
                content: 'バインダーを追加します。'
            }"
            type="button"
            class="form__title-button mdc-elevation--z1"
        >
            Add binder
        </button>
    </div>
</template>

<script>
export default {
    methods: {
        moveToBinderCreate() {
            // バインダー作成画面の入力状態をクリア
            this.$store.dispatch("binderCreate/clear");
            this.$router.push({ name: "binder-create" });
        }
    }
};
</script>
