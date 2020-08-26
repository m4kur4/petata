<template>
    <div class="container--binder">
        <ImageList />
        <ImageContainer />
        <RightColumn />
        <div class="loader"></div>
    </div>
</template>

<script>
import ImageList from "../components/binder/ImageList.vue";
import ImageContainer from "../components/binder/ImageContainer.vue";
import RightColumn from "../components/binder/RightColumn.vue";

export default {
    components: {
        ImageList,
        ImageContainer,
        RightColumn
    },
    computed: {
        isLoading() {
            return this.$store.state.mode.isLoading;
        }
    },
    beforeCreate() {
        // ナビゲーションバーを表示する
        this.$store.commit("mode/setHasNavigation", true);
    },
};
</script>
