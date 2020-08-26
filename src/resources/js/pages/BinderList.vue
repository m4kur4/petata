<template>
    <div class="container--binder-list">
        <Form />
        <div v-if="isLoading" class="loader"></div>
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-list/Form.vue";
import { STATUS } from "../const";

export default {
    components: {
        Form
    },
    computed: {
        isLoading() {
            return this.$store.state.mode.isLoading;
        }
    },
    beforeCreate() {
        this.$store.dispatch("binderList/fetchBinders");

        // ナビゲーションバーを非表示にする
        this.$store.commit("mode/setHasNavigation", false);
    }
};
</script>
