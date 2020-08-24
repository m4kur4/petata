<template>
    <div class="container--binder-create">
        <Form />
        <LabelAddDialog @add-label-click="addLabel" />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-create/Form.vue";
import LabelAddDialog from "../components/common/LabelAddDialog.vue";

export default {
    components: {
        Form,
        LabelAddDialog
    },
    methods: {
        addLabel(labelData) {
          this.$store.commit('binderCreate/addLabel', labelData);
        }
    },
    beforeCreate() {
        this.$store.dispatch("binderCreate/initialize");

        // ナビゲーションバーを表示する
        this.$store.commit("mode/setHasNavigation", false);
    },

};
</script>
