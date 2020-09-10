<template>
    <div>
        <button
            @click="moveToBinderCreate"
            type="button"
            class="form__title-button"
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
            
            this.$router.push("/binder/create");
        }
    }
};
</script>
