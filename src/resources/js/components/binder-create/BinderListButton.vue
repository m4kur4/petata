<template>
    <div>
        <button
            @click="moveToBinderList"
            v-tooltip.left="{
                content: 'バインダー一覧へ戻ります。'
            }"
            type="button"
            class="form__title-button--return mdc-elevation--z1"
        >
            Binder list
        </button>
    </div>
</template>

<script>
export default {
    methods: {
        moveToBinderList() {
            this.$router.push({ name: "binder-list" });
        }
    }
};
</script>
