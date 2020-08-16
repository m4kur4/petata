<template>
    <button v-if="isShow" class="binder-card__button-danger">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="#324750"
            width="64px"
            height="64px"
        >
            <path d="M0 0h24v24H0z" fill="none" />
            <path
                d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"
            />
        </svg>
    </button>
</template>

<script>
export default {
  props: {
    /**
     * 離脱ボタンの表示有無
     * - 他人が作成したバインダー以外は削除不可なので離脱ボタンを表示する
     */
    isShow: {
      type: Boolean,
      default: true
    }
  }
}
</script>