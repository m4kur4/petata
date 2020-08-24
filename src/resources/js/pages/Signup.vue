<template>
    <div class="container--signup">
        <Form />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/signup/Form.vue";

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
