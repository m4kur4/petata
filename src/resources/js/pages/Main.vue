<template>
<div class="container">
  <LeftColumn />
  <ImageContainer />
  <RightColumn />
</div>
</template>

<script>
import LeftColumn from '../components/LeftColumn.vue';
import ImageContainer from '../components/ImageContainer.vue';
import RightColumn from '../components/RightColumn.vue';

export default {
  components: {
    LeftColumn,
    ImageContainer,
    RightColumn
  },
}
</script>