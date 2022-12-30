<template>
    <Teleport to="body">
        <div v-if="isShown"
             class="fixed rounded-3xl bg-white/95 backdrop-blur-2xl p-8 top-1/3 left-1/2 -translate-x-1/2 w-96 drop-shadow-2xl">
            <h2 class="text-lg text-center font-semibold mb-5">
                <slot name="title" />
            </h2>
            <div class="flex justify-end">
                <slot name="buttons" />
            </div>
        </div>
    </Teleport>
</template>

<script setup>
    defineProps({
        isShown: Boolean,
    });
</script>

<style lang="scss" scoped>

</style>
