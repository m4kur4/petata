<template>
    <div class="container--binder-create">
        <Form />
        <LabelAddDialog />
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-create/Form.vue";
import LabelAddDialog from "../components/common/LabelAddDialog.vue";

export default {
    components: {
        Form,
        LabelAddDialog,
    },
};
</script>
