<template>
    <div class="flex px-4 py-3 justify-between gap-2">
        <img :src="user.full_image_path" alt="" class="w-11 h-auto rounded-full ">
        <TextInput class="w-full " v-model="comment" />
        <PrimaryBtn @click.prevent="commentPost">Comment</PrimaryBtn>
    </div>
</template>

<script setup>
    import { computed, ref } from "vue";
    import { usePage } from "@inertiajs/inertia-vue3";
    import TextInput from "@/Components/TextInput.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { Inertia } from "@inertiajs/inertia";

    const comment = ref("");

    const { comments, postId } = defineProps({
        comments: Object,
        postId: Number,
    });
    const user = computed(() => usePage().props.value.auth.user);

    function commentPost() {
        Inertia.post(route("comment.store"), {
            "comment": comment.value,
            "post_id": postId,
        }, {
            preserveScroll: true,
            onSuccess: () => {
                comment.value = "";
            },
        });
    }
</script>
