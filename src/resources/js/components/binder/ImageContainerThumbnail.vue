<template>
    <div class="image-container__thumbnail">
        <img
            class="image-container__thumbnail-image mdc-elevation--z2"
            :src="imageSource"
            :alt="fileName"
        />
    </div>
</template>
<script>
export default {
    props: {
        imageSource: String,
        fileName: String
    }
}
</script>