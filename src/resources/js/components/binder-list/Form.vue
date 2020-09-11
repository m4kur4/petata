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
                <li class="form__tab-all">
                    <h3 class="form__tab-text">All</h3>
                </li>
                <li class="form__tab-own">
                    <h3 class="form__tab-text">Own</h3>
                </li>
                <li class="form__tab-others">
                    <h3 class="form__tab-text">Others</h3>
                </li>
                <li class="form__tab-favorite">
                    <h3 class="form__tab-text">Favorite</h3>
                </li>
            </ul>
            <div class="form__tab-sort-wrapper"></div>
            <div class="form__tab-search-wrapper">
                <button type="button" class="form__tab-search-button">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        width="30px"
                        height="30px"
                    >
                        <path d="M0 0h24v24H0z" fill="none" />
                        <path
                            d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                        />
                    </svg>
                </button>
                <input class="form__tab-search-text" placeholder="Search" />
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
    }
};
</script>
