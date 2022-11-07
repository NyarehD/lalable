<template>
    <button :class="{'primaryBtn':type==='primary','primaryOutlineBtn':type==='outline','primaryTextBtn':type==='text'}">
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
    });
</script>
