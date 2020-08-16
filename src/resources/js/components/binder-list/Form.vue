<template>
    <form class="form--binder-list">
        <FormTitle :clazz="'form__title--binder-list'">Binder list</FormTitle>

        <div class="form__nav--binder-list">
            <ul class="form__tab-wrapper">
                <li class="form__tab--selected">
                    <h3 class="form__tab-text">All</h3>
                </li>
                <li class="form__tab">
                    <h3 class="form__tab-text">Your own</h3>
                </li>
                <li class="form__tab">
                    <h3 class="form__tab-text">Paricipated</h3>
                </li>
                <li>
                    <h3 class="form__tab-text">Favorite</h3>
                </li>
            </ul>
            <div>
                <input class="form__tab-search" placeholder="Search" />
            </div>
        </div>

        <div class="form__binder-card-wrapper">
            <Card
                :create_user_id="'1'"
                :title="'バインダー１'"
                :description="'自分で作成したバインダー'"
                :thumbnailUrl="'image/dummy/dummy.jpg'"
                :countParticipated="4"
                :countImage="1"
                :countFavorite="3"
                :isFavorite="false"
            />
            <Card
                :create_user_id="'2'"
                :title="'バインダー２'"
                :description="'他人が作成したバインダー'"
                :thumbnailUrl="'image/dummy/dummy.jpg'"
                :countParticipated="4"
                :countImage="1"
                :countFavorite="3"
                :isFavorite="false"
            />
            <Card
                :create_user_id="'2'"
                :title="'バインダー３'"
                :description="'お気に入り登録しているバインダー'"
                :thumbnailUrl="'image/dummy/dummy.jpg'"
                :countParticipated="4"
                :countImage="1"
                :countFavorite="3"
                :isFavorite="true"
            />
        </div>
    </form>
    <!-- /.form -->
</template>

<script>
import FormTitle from "../common/FormTitle.vue";
import Card from "./Card.vue";

export default {
    components: {
        FormTitle,
        Card
    }
};
</script>
