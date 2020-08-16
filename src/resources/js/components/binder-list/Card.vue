<template>
    <div class="form__binder-card">
        <div
            :class="{
                'binder-card__info--favorite': isFavorite,
                'binder-card__info--own': !isFavorite && isOwn,
                'binder-card__info--participated': !isFavorite && !isOwn
            }"
        >
            <img
                class="binder-card__info-thumbnail"
                :src="thumbnailUrl"
                :alt="title"
            />
            <div class="binder-card__info-title">
                <h3>{{ title }}</h3>
            </div>
            <div class="binder-card__info-description">
                <h4>
                    {{ description }}
                </h4>
            </div>
            <CountInfo
                :countParticipated="countParticipated"
                :countImage="countImage"
                :countFavorite="countFavorite"
            />
        </div>
        <div class="binder-card__button-menu">
            <FavoriteButton :isFavorite="isFavorite" />
        </div>
        <div class="binder-card__button-danger">
            <DeleteButton :isShow="isOwn" />
            <LeaveButton :isShow="!isOwn" />
        </div>
        <!-- /.binder-card__info -->
    </div>
    <!-- /.form__binder-card -->
</template>

<script>
import CountInfo from "./CountInfo.vue";
import FavoriteButton from "./FavoriteButton.vue";
import DeleteButton from "./DeleteButton.vue";
import LeaveButton from "./LeaveButton.vue";

export default {
    components: {
        CountInfo,
        FavoriteButton,
        DeleteButton,
        LeaveButton
    },
    props: {
        /**
         * バインダー作成ユーザーID
         */
        create_user_id: {
            type: String,
            required: true
        },
        /**
         * バインダー名
         */
        title: {
            type: String,
            required: true
        },
        /**
         * バインダーの説明
         */
        description: {
            type: String
        },
        /**
         * バインダーのサムネイルURL
         * TODO: ダミー画像の格納
         */
        thumbnailUrl: {
            type: String,
            default: ""
        },
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
         * バインダーお気に入り登録数
         */
        countFavorite: {
            type: Number,
            default: 0
        },
        /**
         * ログインユーザーのお気に入り登録有無
         */
        isFavorite: {
            type: Boolean,
            default: false
        }
    },
    computed: {
        /**
         * ログインユーザーが作成したバインダーかどうか
         */
        isOwn() {
            // DEBUG:
            return '1' === this.create_user_id;
            //return this.$store.state.auth.user.id === this.create_user_id;
        }
    }
};
</script>
