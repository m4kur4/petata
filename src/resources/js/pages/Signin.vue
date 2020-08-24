<template>
    <div class="container--signin">
        <Form />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/signin/Form.vue";

export default {
    components: {
        Form
    },
    beforeCreate() {
        // ナビゲーションバーを非表示にする
        this.$store.commit("mode/setHasNavigation", false);
    },
};
</script>
