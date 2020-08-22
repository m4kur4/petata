<template>
    <div>
        <label class="form__label"
            >{{ title }}
            <span v-if="errors" class="form__error-message">
                <div v-for="msg in errors" :key="msg">{{ msg }}</div></span
            >
        </label>
        <textarea
            v-model="text"
            :placeholder="placeholder"
            class="form__text-area"
            cols="50"
            rows="8"
            wrap="soft"
        ></textarea>
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
        value: String,
        title: String,
        type: String,
        placeholder: String
    },
    computed: {
        text: {
            get: function() {
                return this.value;
            },
            set: function(value) {
                this.$emit("input", value);
            }
        }
    }
};
</script>
