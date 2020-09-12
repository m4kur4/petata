<template>
    <div class="container--binder-list">
        <div class="progress-indicator-wrapper">
            <ProgressIndicator />
        </div>
        <Form />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-list/Form.vue";
import ProgressIndicator from "../components/common/ProgressIndicator.vue";
import { STATUS } from "../const";

export default {
    components: {
        Form,
        ProgressIndicator
    },
    beforeCreate() {
        this.$store.dispatch("binderList/fetchBinders");

        // ナビゲーションバーを非表示にする
        this.$store.commit("mode/setHasNavigation", false);
    }
};
</script>
