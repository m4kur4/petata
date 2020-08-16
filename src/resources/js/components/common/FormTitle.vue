<template>
<div :class="clazz">
    <h2>
        <img
            src="image/logo/logo_32.svg"
            width="48"
            height="48"
            alt="petata"
        />
        <slot>
          <!-- SLOT: ここに文言を入れる -->
        </slot>
    </h2>
</div>
</template>
<script>
export default {
    props: {
        /**
         * クラス属性
         */
        clazz: {
            type: String,
            default: 'form__title'
        },
    },
}
</script>