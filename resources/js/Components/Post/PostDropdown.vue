<template>
    <div class="relative" ref="dropdown">
        <PrimaryBtn class="h-10 p-2" type="text" @click.stop="isDropdownActive=!isDropdownActive">
            <EllipsisVerticalIcon />
        </PrimaryBtn>
        <div class="absolute right-0 z-10 bg-white border-[1px] border-gray-500/20 rounded-3xl w-32"
             :class="{'fade':isDropdownActive}"
             v-show="isDropdownActive">
            <Link @click.stop :href="route('post.show',{id:postId})"
                  class="py-2 px-6 hover:bg-indigo-200/80 active:bg-indigo-300/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer"
                  v-if="route().current()!=='post.show'" preserve-scroll>
                View
            </Link>
            <Link @click.stop v-if="isPostOwner" :href="route('post.edit',{id:postId})"
                  class="py-2 px-6 hover:bg-indigo-200/80 active:bg-indigo-300/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer"
                  preserve-scroll>
                Edit
            </Link>
            <PostDropdownDelete :post-id="postId" v-if="isPostOwner" />
        </div>
    </div>
</template>
<script setup>
    import EllipsisVerticalIcon from "@/Components/Icons/EllipsisVerticalIcon.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import PostDropdownDelete from "@/Components/Post/PostDropdownDelete.vue";
    import { Link } from "@inertiajs/inertia-vue3";
    import { ref } from "vue";
    import { onClickOutside } from "@vueuse/core";

    defineProps({
        postId: Number,
        isPostOwner: Boolean,
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
