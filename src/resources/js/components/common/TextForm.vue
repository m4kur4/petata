<template>
    <div>
        <label class="form__label"
            >{{ title }}
            <span v-if="errors" class="form__error-message">
                <div v-for="msg in errors" :key="msg">{{ msg }}</div></span
            >
        </label>
        <input
            v-model="bind_target"
            :placeholder="placeholder"
            :type="type"
            class="form__text"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: null
        };
    },
    props: {
        title: String,
        bind_target: String,
        type: String,
        placeholder: String
    }
};
</script>
