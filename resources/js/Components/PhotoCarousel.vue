<template>
    <div class="relative">
        <img :src="photo.photo_src" v-for="(photo,i) in photos" :key="i" class="w-full "
             :class="{'object-cover h-96':!isFullHeight,'h-screen object-contain':isFullHeight}"
             loading="lazy" v-show="i===currentPhoto">
        <PrimaryBtn class="p-1 border-none absolute top-1/2 -translate-y-1/2 left-1" type="outline"
                    @click.prevent="minusOne" v-show="!isFirstPhoto">
            <PreviousIcon />
        </PrimaryBtn>
        <PrimaryBtn class="p-1 border-none absolute top-1/2 -translate-y-1/2 right-1" type="outline"
                    @click.prevent="addOne"
                    v-show="!isLastPhoto">
            <NextIcon />
        </PrimaryBtn>
    </div>
</template>

<script setup>
    import { computed, ref } from "vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import NextIcon from "@/Components/Icons/NextIcon.vue";
    import PreviousIcon from "@/Components/Icons/PreviousIcon.vue";

    const { photos, isFullHeight } = defineProps({
        photos: Object,
        isFullHeight: {
            type: Boolean,
            default: false,
        },
    });

    const currentPhoto = ref(0);
    const isFirstPhoto = computed(() => currentPhoto.value === 0);
    const isLastPhoto = computed(() => (photos.length - 1) === currentPhoto.value);

    const addOne = () => !isLastPhoto.value && currentPhoto.value++;
    const minusOne = () => !isFirstPhoto.value && currentPhoto.value--;
</script>

<style scoped>
</style>
