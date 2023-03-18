<template>
  <div class="max-w-2xl min-h-screen px-2 mx-auto">
    <h3 class="dark:text-white mb-3 text-xl font-semibold" v-if="posts.length">Results for "{{ keyword }}" showing
      {{ totalPostsNumber }} of {{ postThing }}</h3>
    <Post v-for="(post, i) in $props.posts" :post="post" :key="`${post.id}post${i}`" v-memo="[post.user_liked_count]" />
    <div
      class="max-w-2xl border-[1px] rounded-3xl px-6 py-3 text-center border-gray-500/20 dark:border-neutral-200/20 dark:text-white"
      v-if="!posts.length">
      There are no posts for keyword "{{ $props.keyword }}"
    </div>
  </div>
  <TextToast :text="$page.props.message" :duration="1000" />
</template>
<script setup lang="ts">
  import Post from "@/Components/Post/Post.vue";
  import TextToast from "@/Components/TextToast.vue";
  import { default as PostType } from "@/Types/post.type";
  import { computed } from "vue";

  const props = defineProps<{
    posts: PostType[],
    keyword: String
  }>();

  const totalPostsNumber = computed(() => props.posts.length)
  const postThing = computed(() => props.posts.length > 0 ? "posts" : "post")
</script>
<script lang="ts">
  import PageLayout from "@/Layouts/PageLayout.vue";
  import PostShow from "./PostShow.vue";

  export default {
    layout: PageLayout,
  };
</script>
