<template>
    <div>

            <label class="form__label"
                ><span>{{ title }}</span>
                <span v-if="errors" class="form__error-message">
                    <div v-for="msg in errors" :key="msg">{{ msg }}</div></span
                >
            </label>

        <input
            v-model="text"
            :placeholder="placeholder"
            :type="type"
            class="form__text"
        />
    </div>
</template>

<script>
export default {
    props: {
        value: String,
        title: String,
        type: String,
        placeholder: String,
        errors: {
            type: Array,
            default: null
        }
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
