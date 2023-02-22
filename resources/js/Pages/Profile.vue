<template>
  <div class="flex flex-col max-w-4xl gap-4 mx-auto md:flex-row">
    <!-- Container for Profile -->
    <div class="static md:sticky top-20 flex md:flex-col md:h-full rounded-3xl border-gray-500/20 border-[1px] md:mb-3">
      <div class="w-1/3 md:w-full">
        <img :src="user.full_image_path" class="w-full rounded-3xl" :alt="`profile picture of ${user.name}`" />
      </div>
      <div class="flex flex-col w-2/3 px-6 py-3 md:h-full">
        <div>
          <h2 class="text-3xl">{{ user.name }}</h2>
          <p class="mt-3">{{ user.bio ?? "Please add your bio" }}</p>
        </div>
      </div>
    </div>
    <!-- Section for Profile's posts -->
    <div class="flex rounded-3xl">
      <div class="">
        <Post v-for="(post) in posts" :post="post" :key="`posts${post.id}`" v-memo="[post.user_liked_count]" />
      </div>
    </div>
  </div>
</template >

<script setup lang ="ts">
  import Post from "@/Components/Post/Post.vue"

  export interface Post {
    id: number
  }
  export interface User {
    id: number
    name: string
    bio: string
    full_image_path: string
  }

  defineProps<{ user: User, posts: Post[] }>()

</script>

<script lang="ts">
  import PageLayout from '@/Layouts/PageLayout.vue'
  export default {
    layout: PageLayout
  }
</script>

<style lang="scss" scoped></style>
