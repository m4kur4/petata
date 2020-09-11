<template>
    <div class="container--binder-create">
        <Form />
        <LabelAddDialog @add-label-click="setLabel" />
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
        setLabel(labelData) {
          this.$store.commit('binderCreate/setLabel', labelData);
        }
    },
    beforeCreate() {
        // ナビゲーションバーを非表示にする
        this.$store.commit("mode/setHasNavigation", false);
        // トランジション遷移の制御
        this.$store.commit("mode/setIsInnerPage", true);
    },

};
</script>
