<template>
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
                <div
                    class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                    <button>View</button>
                </div>
                <div
                    class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                    Delete
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
    import EllipsisVerticalIcon from "@/Components/Icons/EllipsisVerticalIcon.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { ref } from "vue";

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
