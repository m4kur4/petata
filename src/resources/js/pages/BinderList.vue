<template>
    <div class="container--binder-list">
        <Form />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-list/Form.vue";
export default {
    components: {
        Form
    },
    beforeCreate() {
        this.$store.dispatch("binderList/fetchBinders");
    }
};
</script>
