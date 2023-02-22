<template>
    <div class="max-w-2xl px-2 mx-auto">
        <Post v-for="(post, i) in $props.posts" :post="post" :key="`${post.id}post${i}`" v-memo="[post.user_liked_count]" />
    </div>
    <!-- <div v-if="!data.next_page_url"> -->
    <!-- No more posts -->
    <!-- </div> -->
    <TextToast :text="$page.props.message" :duration="1000" />
</template>
<script setup lang="ts">
    import Post from "@/Components/Post/Post.vue";
    import TextToast from "@/Components/TextToast.vue";
    import { useInfiniteScroll } from "@vueuse/core";
    import { onMounted } from "vue";
    import { ref } from "vue";


    const props = defineProps<{
        posts: any[]
    }>();

                                                // const posts = ref(props.data.data);

                                                // onMounted(() => {
                                                //     useInfiniteScroll(window, () => {
                                                //         if (props.data.next_page_url) {
                                                //             fetch(props.data.next_page_url).then(response => response.json()).then(data => {
                                                //                 posts.value = [...posts.value, ...data.data];
                                                //                 props.data.next_page_url = data.next_page_url;
                                                //             })
                                                //         }
                                                //     })
                                                // })
</script>
<script lang="ts">
    import PageLayout from "../Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
