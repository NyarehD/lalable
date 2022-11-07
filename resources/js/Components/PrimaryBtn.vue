<template>
    <button :class="{'primaryBtn':type==='primary','primaryOutlineBtn':type==='outline','disabledBtn':isDisabled}"
            :disabled="isDisabled">
        <slot />
    </button>
</template>
<script setup>
    defineProps({
        type: {
            default: "primary",
            type: String,
            required: false,
        },
        isDisabled: {
            default: false,
            type: Boolean,
            required: false,
        },
    });
</script>
