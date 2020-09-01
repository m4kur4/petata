<template>
    <div class="label-container__item mdc-elevation--z2">
        <p class="label-container__item-title">{{ name }}</p>
        <p class="label-container__item-description">
            {{ description }}
        </p>
    </div>
</template>

<script>
export default {
    props: {
        id: null,
        name: '',
        description: ''
    }
}
</script>