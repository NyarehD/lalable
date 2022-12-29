<template>
    <div class="flex py-3 px-4 justify-between">
        <div class="flex">
            <img :src="post.owner.full_image_path" :alt="post.owner.name" class="w-12 h-12 rounded-full">
            <div class="ml-3">
                <p class="font-semibold"> {{ post.owner.name }}</p>
                <p>{{ post.for_humans }}</p>
            </div>
        </div>
        <DropAlt>
            <Link @click.stop :href="route('post.show',{id:post.id})"
                  class="dropdownLink"
                  v-if="route().current()!=='post.show'" preserve-scroll>
                View
            </Link>
            <Link @click.stop v-if="post.can.is_post_owner" :href="route('post.edit',{id:post.id})"
                  class="dropdownLink"
                  preserve-scroll>
                Edit
            </Link>
            <PostDropdownDelete :post-id="post.id" v-if="post.can.is_post_owner" />
        </DropAlt>
    </div>
</template>
<script setup>
    import DropAlt from "@/Components/DropAlt.vue";
    import PostDropdownDelete from "@/Components/Post/PostDropdownDelete.vue";
    import { Link } from "@inertiajs/inertia-vue3";

    defineProps({
        post: Object,
    });

</script>
<style>
</style>
