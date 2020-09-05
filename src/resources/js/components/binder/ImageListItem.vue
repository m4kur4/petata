<template>
    <div class="image-list__item">
        <div class="image-list__item-thumbnail">
            <img
                class="image-list__item-thumbnail-image"
                :id="`image-list-item-thumbnail-${id}`"
                :alt="fileName"
                :src="imageSource"
            />
        </div>
        <div class="image-list__item-text">{{ fileName }}</div>
    </div>
    <!-- /.image-list__item -->
</template>

<script>
export default {
    props: {
        id: Number,
        imageSource: String,
        fileName: String
    }
}
</script>