<template>
  <div class="label-container">
    <LabelItem
      v-for="label in labels"
      :key="label.name"
      :name="label.name"
      :description="label.description"
    />
    <LabelItem :name="'ラベル名2'" :description="'ラベルの説明2'" />
    <LabelItem :name="'ラベル名3'" :description="'ラベルの説明3'" />
    <LabelItem :name="'ラベル名4'" :description="'ラベルの説明4'" />
  </div>
  <!-- /.label-container -->
</template>

<script>
import LabelItem from "./LabelItem";
export default {
  components: {
    LabelItem,
  },
  props: {
    labels: Array,
  },
};
</script>