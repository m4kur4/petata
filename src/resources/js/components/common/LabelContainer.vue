<template>
    <div class="label-container">
        <LabelItem
            v-for="label in labels"
            :key="label.id"
            :id="label.id"
            :name="label.name"
            :description="label.description"
        />
    </div>
    <!-- /.label-container -->
</template>

<script>
import LabelItem from "./LabelItem";
export default {
    components: {
        LabelItem
    },
    props: {
        labels: Array
    }
};
</script>
