<template>
<div :class="clazz">
    <h2>    
        <slot name="title">
          <!-- SLOT: ここに文言を入れる -->
        </slot>
    </h2>
    <slot name="additional-content">
        <!-- SLOT: ボタン等の追加要素 -->
    </slot>
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