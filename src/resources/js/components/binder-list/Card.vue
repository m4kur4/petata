<template>
    <div class="form__binder-card">
        <div
            @dblclick.stop="moveToBinder"
            v-tooltip.bottom-start="{
                content: 'ダブルクリックでバインダーを開きます。',
                delay: { show: 1250, hide: 100 },
                hideOnTargetClick: false
            }"
            :class="{
                'binder-card__info--favorite': isFavorite,
                'binder-card__info--own': !isFavorite && isOwn,
                'binder-card__info--participated': !isFavorite && !isOwn
            }"
        >
            <img
                class="binder-card__info-thumbnail"
                :src="thumbnailUrl"
                :alt="name"
            />
            <div class="binder-card__info-title">
                <h3>{{ name }}</h3>
            </div>
            <div class="binder-card__info-description">
                <h4>
                    {{ description }}
                </h4>
            </div>
            <CountInfo
                :countUser="countUser"
                :countImage="countImage"
                :countFavorite="countFavorite"
            />
        </div>
        <div class="binder-card__button-menu">
            <EditBinderButton v-if="isOwn" :binder="binder" />
            <FavoriteBinderButton :binderId="id" :isFavorite="isFavorite" />
        </div>
        <div class="binder-card__button-menu">
            <DeleteBinderButton :isShow="isOwn" />
            <LeaveBinderButton :isShow="!isOwn" />
        </div>
        <!-- /.binder-card__info -->
    </div>
    <!-- /.form__binder-card -->
</template>

<script>
import CountInfo from "./CountInfo.vue";
import FavoriteBinderButton from "./FavoriteBinderButton.vue";
import DeleteBinderButton from "./DeleteBinderButton.vue";
import LeaveBinderButton from "./LeaveBinderButton.vue";
import EditBinderButton from "./EditBinderButton.vue";

export default {
    components: {
        CountInfo,
        FavoriteBinderButton,
        DeleteBinderButton,
        LeaveBinderButton,
        EditBinderButton
    },
    props: {
        /**
         * バインダーID
         */
        id: {
            type: Number,
            required: true
        },
        /**
         * バインダー名
         */
        name: {
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
         * バインダーお気に入り登録数
         */
        countFavorite: {
            type: Number,
            default: 0
        },
        /**
         * バインダーがログインユーザーのものかどうか
         */
        isOwn: {
            type: Boolean,
            default: false
        },
        /**
         * ログインユーザーのお気に入り登録有無
         */
        isFavorite: {
            type: Boolean,
            default: false
        },
        /**
         * バインダー情報
         */
        binder: {
            type: Object
        }
    },
    methods: {
        moveToBinder() {
            this.$router.push({ name: "binder", params: { id: this.id } });
        }
    }
};
</script>
