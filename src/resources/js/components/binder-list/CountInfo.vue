<template>
    <div class="binder-card__info-counter">
        <Counter
            :src="'/image/icon/perm_identity-black-24dp.svg'"
            :alt="'参加者数'"
            :count="countUser"
        />
        <Counter
            :src="'/image/icon/image-black-24dp.svg'"
            :alt="'画像数'"
            :count="countImage"
        />
        <Counter
            :src="'/image/icon/bookmarks-24px.svg'"
            :alt="'ラベル数'"
            :count="countLabel"
        />
    </div>
</template>

<script>
import Counter from "./Counter.vue";
export default {
    components: {
        Counter
    },
    props: {
        /**
         * バインダー参加者数
         */
        countUser: {
            type: Number,
            default: 0
        },
        /**
         * バインダー登録画像数
         */
        countImage: {
            type: Number,
            default: 0
        },
        /**
         * バインダー登録ラベル数
         */
        countLabel: {
            type: Number,
            default: 0
        },
        /**
         * バインダーお気に入り被登録数
         */
        countFavorite: {
            type: Number,
            default: 0
        }
    }
};
</script>
