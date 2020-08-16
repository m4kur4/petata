<template>
    <div class="binder-card__info-counter">
        <Counter
            :src="'image/icon/perm_identity-black-24dp.svg'"
            :alt="'参加者数'"
            :count="countParticipated"
        />
        <Counter
            :src="'image/icon/image-black-24dp.svg'"
            :alt="'画像数'"
            :count="countImage"
        />
        <Counter
            :src="'image/icon/star_border-black-24dp.svg'"
            :alt="'お気に入り数'"
            :count="countFavorite"
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
        countParticipated: {
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
         * バインダーお気に入り被登録数
         */
        countFavorite: {
            type: Number,
            default: 0
        }
    }
};
</script>
