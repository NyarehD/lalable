<template>
    <div
        class="border-x-[1px] border-b-[1px] border-gray-500/20 first-of-type:border-t-2 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl">
        <div class="flex py-3 px-4 justify-between">
            <div class="flex">
                <img :src="post.owner.full_image_path" :alt="post.owner.name" class="w-12 h-12 rounded-full">
                <div class="ml-3">
                    <p class="font-semibold"> {{ post.owner.name }}</p>
                    <p>{{ post.for_humans }}</p>
                </div>
            </div>
            <div class="relative">
                <PrimaryBtn class="h-10 p-2" type="text" @click="isDropdownActive=!isDropdownActive">
                    <EllipsisVerticalIcon />
                </PrimaryBtn>
                <div class="absolute right-0 z-10 bg-white border-[1px] border-gray-500/20 rounded-3xl w-32"
                     :class="{'fade':isDropdownActive}"
                     v-if="isDropdownActive">
                    <Link :href="route('post.show',{id:post.id})" :headers="{foo:'bar'}"
                          class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                        View
                    </Link>
                    <Link
                        class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                        Delete
                    </Link>
                </div>
            </div>
        </div>
        <div class="px-4 pb-1" v-if="post.description">
            <p class="text-lg">{{ post.description }}</p>
        </div>
        <img :src="post.post_photos[0].photo_src" class="max-h-[30rem] w-full object-cover"
             v-if="post.post_photos.length===1">
        <PhotoCarousel :photos="post.post_photos" v-if="post.post_photos.length>1" />
    </div>
</template>
<script setup>
    import PhotoCarousel from "@/Components/PhotoCarousel.vue";
    import EllipsisVerticalIcon from "@/Components/Icons/EllipsisVerticalIcon.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { Link } from "@inertiajs/inertia-vue3";


    import { ref } from "vue";

    defineProps({
        post: Object,
    });

    const isDropdownActive = ref(false);
</script>
<style lang="scss">
    .fade {
        animation: fade 300ms cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    }

    @keyframes fade {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
