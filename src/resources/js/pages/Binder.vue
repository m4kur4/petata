<template>
<div class="container--binder">
  <LeftColumn />
  <ImageContainer />
  <RightColumn />
</div>
</template>

<script>

import LeftColumn from '../components/binder/LeftColumn.vue';
import ImageContainer from '../components/binder/ImageContainer.vue';
import RightColumn from '../components/binder/RightColumn.vue';

export default {
  components: {
    LeftColumn,
    ImageContainer,
    RightColumn
  },
}
</script>