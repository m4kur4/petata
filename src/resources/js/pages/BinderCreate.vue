<template>
    <div
        :class="[
            'container--binder-create',
            { 'filtered-for-modal': isShowDialog }
        ]"
    >
        <Form />
        
    </div>
    <!-- /.container -->
</template>

<script>
import Form from "../components/binder-create/Form.vue";

export default {
    components: {
        Form
    },
    props: {
        isShowDialog: false
    }
};
</script>
