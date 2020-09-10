<template>
    <form class="form--binder-list">
        <FormTitle :clazz="'form__title--binder-list'">
            <template v-slot:title>Binder list</template>
            <template v-slot:additional-content>
                <AddBinderButton />
            </template>
        </FormTitle>
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
                v-for="binder in binders"
                :key="binder.id"
                :id="binder.id"
                :name="binder.name"
                :description="binder.description"
                :thumbnailUrl="'/image/dummy/dummy.jpg'"
                :countUser="binder.count_user"
                :countImage="binder.count_image"
                :countLabel="binder.count_label"
                :countFavorite="binder.count_favorite"
                :isOwn="binder.is_own"
                :isFavorite="binder.is_favorite"
                :binder="binder"
            />
            <Card
                :id="2"
                :name="'バインダー２'"
                :description="'他人が作成したバインダー'"
                :thumbnailUrl="'/image/dummy/dummy.jpg'"
                :countParticipated="4"
                :countImage="1"
                :countFavorite="3"
                :isFavorite="false"
                :binder="null"
            />
            <Card
                :id="2"
                :name="'バインダー３'"
                :description="'お気に入り登録しているバインダー'"
                :thumbnailUrl="'/image/dummy/dummy.jpg'"
                :countParticipated="4"
                :countImage="1"
                :countFavorite="3"
                :isFavorite="true"
                :binder="null"
            />
        </div>
    </form>
    <!-- /.form -->
</template>

<script>
import FormTitle from "../common/FormTitle.vue";
import Card from "./Card.vue";
import AddBinderButton from "./AddBinderButton.vue";

export default {
    components: {
        FormTitle,
        Card,
        AddBinderButton
    },
    computed: {
        binders() {
            return this.$store.state.binderList.binders;
        }
    },
};
</script>
