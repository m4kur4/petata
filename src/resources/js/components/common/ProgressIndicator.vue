<template>
    <transition name="progressbar-fade">
        <div
            v-if="isConnetcing"
            role="progressbar"
            class="progress-indicator mdc-linear-progress mdc-linear-progress--indeterminate"
        >
            <div class="mdc-linear-progress__buffering-dots"></div>
            <div class="mdc-linear-progress__buffer"></div>
            <div
                class="mdc-linear-progress__bar mdc-linear-progress__primary-bar"
            >
                <span
                    class="mdc-linear-progress__bar-inner"
                    style="border-color: #496875"
                ></span>
            </div>
            <div
                class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar"
            >
                <span
                    class="mdc-linear-progress__bar-inner"
                    style="border-color: #496875"
                ></span>
            </div>
        </div>
    </transition>
</template>
<script>
export default {
    computed: {
        isConnetcing() {
            return this.$store.state.mode.isConnecting;
        }
    }
};
</script>
