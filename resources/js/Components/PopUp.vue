<template>
    <Teleport to="body">
        <div v-if="isShown" ref="popUp"
             class="fixed rounded-3xl bg-white/95 backdrop-blur-2xl p-8 top-1/3 left-1/2 -translate-x-1/2 max-w-[30rem] drop-shadow-2xl">
            <h2 class="text-lg text-center font-semibold mb-5">
                <slot name="title" />
            </h2>
            <div class="mb-5">
                <slot name="content" />
            </div>
            <div class="flex justify-end">
                <slot name="buttons" />
            </div>
        </div>
    </Teleport>
</template>

<script setup>

    import { ref } from "vue";
    import { onClickOutside } from "@vueuse/core";

    const popUp = ref(null);
    let { isShown } = defineProps({
        isShown: Boolean,
    });
    const emits = defineEmits([
        "clickedOutside",
    ]);

    onClickOutside(popUp, () => emits("clickedOutside"));
</script>

<style lang="scss" scoped>

</style>
