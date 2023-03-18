<template>
  <div class="md:flex-row flex flex-col max-w-4xl gap-4 mx-auto">
    <!-- Container for Profile -->
    <div class="md:w-1/3 md:sticky top-20 md:flex-col md:h-full static flex">
      <div class="flex md:flex-col rounded-3xl border-gray-500/20 dark:border-neutral-200/20 border-[1px] md:mb-3">
        <div class="md:w-full w-1/3">
          <img :src="user.full_image_path" class="rounded-3xl w-full" :alt="`profile picture of ${user.name}`" />
        </div>
        <div class="md:h-full flex flex-col w-2/3 px-6 py-3">
          <div>
            <h2 class="dark:text-white text-3xl">{{ user.name }}</h2>
            <p class="dark:text-white/90 mt-3">{{ user.bio ?? "Please add your bio" }}</p>
          </div>
        </div>
      </div>
      <div
        class="rounded-3xl dark:border-neutral-200/20 border-gray-500/20 border-[1px] md:mb-3 py-3 px-6 hidden md:block">
        <div class="">
          <Link :href="route('user.edit', { user: user.id })" method="get" class="primaryBtn inline-flex items-center">
          <PencilSquareIcon />
          <span class="ml-1">Edit</span>
          </Link>
        </div>
      </div>
    </div>
    <!-- Section for Profile's posts -->
    <div class="md:w-2/3 rounded-3xl flex flex-col">
      <Post v-for="(post) in posts" :post="post" :key="`posts${post.id}`" v-memo="[post.user_liked_count]"
        v-if="posts.length" />
      <div
        class="bg-white border-[1px] rounded-3xl h-20 items-center flex w-full border-gray-500/20 hover:bg-gray-200/50 py-3 px-6"
        v-if="!posts.length">
        There nothing posted by you at the moment.
      </div>
    </div>
  </div>
</template >

<script setup lang ="ts">
  import PencilSquareIcon from "@/Components/Icons/PencilSquareIcon.vue"
  import Post from "@/Components/Post/Post.vue"
  import { default as PostType } from "@/Types/post.type"
  import User from "@/Types/user.type"
  import { Link } from "@inertiajs/vue3"

  defineProps<{ user: User, posts: PostType[] }>()
</script>

<script lang="ts">
  import PageLayout from '@/Layouts/PageLayout.vue'
  export default {
    layout: PageLayout
  }
</script>

<style lang="scss" scoped></style>
