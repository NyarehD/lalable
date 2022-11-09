<template>
    <div class="relative" ref="dropdown">
        <PrimaryBtn class="h-10 p-2" type="text" @click="isDropdownActive=!isDropdownActive">
            <EllipsisVerticalIcon />
        </PrimaryBtn>
        <div class="absolute right-0 z-10 bg-white border-[1px] border-gray-500/20 rounded-3xl w-32"
             :class="{'fade':isDropdownActive}"
             v-show="isDropdownActive">
            <Link :href="route('post.show',{id:postId})" :headers="{foo:'bar'}"
                  class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                View
            </Link>
            <Link
                class="py-2 px-6 hover:bg-gray-200/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
                Delete
            </Link>
        </div>
    </div>
</template>
<script setup>
    import EllipsisVerticalIcon from "@/Components/Icons/EllipsisVerticalIcon.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { ref } from "vue";
    import { onClickOutside } from "@vueuse/core";

    defineProps({
        postId: Number,
    });
    const isDropdownActive = ref(false);

    const dropdown = ref(null);
    onClickOutside(dropdown, () => isDropdownActive.value = false);

</script>
<style>
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
