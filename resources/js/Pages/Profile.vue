<template>
  <div class="container mx-auto">
    <!-- Container for Profile -->
    <div class="flex rounded-3xl">
      <div class="w-1/3">
        <img :src="user.full_image_path" class="w-full rounded-3xl" :alt="`profile picture of ${user.name}`" />
      </div>
      <div class="w-2/3 flex flex-col py-3 px-6">
        <div>
          <h2 class="text-3xl">{{ user.name }}</h2>
          <p class="mt-3">{{ user.bio ?? "Please add your bio" }}</p>
        </div>
      </div>
    </div>
    <!-- Section for Profile's posts -->
    <div class="flex rounded-3xl">
      <div class="w-1/3">

      </div>
      <div class="w-2/3">
        <Post v-for="(post) in user.posts" :post="post" :key="post.id" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import Post from "@/Components/Post/Post.vue"

export interface Post {
  id: number
}
export interface User {
  id: number
  name: string
  bio: string
  full_image_path: string
  posts: Post[]
}

defineProps<{ user: User }>()

</script>

<script lang="ts">
import PageLayout from '@/Layouts/PageLayout.vue';
export default {
  layout: PageLayout
}
</script>

<style lang="scss" scoped>

</style>