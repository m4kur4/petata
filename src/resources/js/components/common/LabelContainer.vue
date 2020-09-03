<template>
    <div class="label-container">
        <LabelItem
            v-for="(label, index) in labels"
            :index="index"
            :key="index"
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
