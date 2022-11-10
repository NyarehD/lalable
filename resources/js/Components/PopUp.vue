<template>
    <div class="fixed rounded-3xl bg-white/95 backdrop-blur-2xl p-8 top-1/3 left-1/2 -translate-x-1/2 w-96 drop-shadow-2xl">
        <h2 class="text-lg text-center font-semibold mb-5">
            <slot />
        </h2>
        <div class="flex justify-end">
            <PrimaryBtn type="outline" class="border-red-600 text-red-600 hover:bg-red-600 mr-3" @click.stop="$emit('delete')">Delete</PrimaryBtn>
            <PrimaryBtn @click.stop="$emit('cancel')">Cancel</PrimaryBtn>
        </div>
    </div>
</template>
<script setup>
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";</script>
