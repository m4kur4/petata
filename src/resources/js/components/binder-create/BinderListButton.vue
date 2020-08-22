<template>
    <div>
        <button
            @click="moveToBinderList"
            type="button"
            class="form__title-button--return"
        >
            Binder list
        </button>
    </div>
</template>

<script>
export default {
    methods: {
        moveToBinderList() {
            this.$router.push("/binder/list");
        }
    }
};
</script>
