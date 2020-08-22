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
            this.$router.push("/binder/create");
        }
    }
};
</script>
