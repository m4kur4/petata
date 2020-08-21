<template>
    <div class="container--binder-create">
        <Form @open-label-add-dialog="showDialog" @close-label-add-dialog="hideDialog" />
        <LabelAddDialog />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-create/Form.vue";
import LabelAddDialog from "../components/binder-create/LabelAddDialog.vue";
import ModalBackground from "../components/common/ModalBackground.vue";

export default {
    components: {
        Form,
        LabelAddDialog,
        ModalBackground
    },
    methods: {
        /**
         * ラベル追加ダイアログを開く
         */
        showDialog() {
            this.isShowLabelAddDialog = true;
            this.$store.commit('mode/setIsShowDialog', true);
        },
        /**
         * ラベル追加ダイアログを閉じる
         */
        hideDialog() {
            this.isShowLabelAddDialog = false;
            this.$store.commit('mode/setIsShowDialog', false);
        },
    },
    computed: {
        isShowDialog() {
            return this.$store.state.mode.isShowDialog;
        },
    },
};
</script>
