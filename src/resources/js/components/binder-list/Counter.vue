<template>
    <div><img :src="src" :alt="alt" width="24" height="24" />{{ count }}</div>
</template>

<script>
export default {
    props: {
        src: {
            type: String,
            required: true
        },
        alt: {
            type: String
        },
        count: {
            type: Number,
            default: 0
        }
    }
};
</script>
