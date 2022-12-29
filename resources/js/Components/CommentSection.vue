<template>
    <div class="flex flex-col">
        <div class="flex px-4 py-3 justify-between gap-2 grow-0">
            <img :src="user.full_image_path" alt="" class="w-11 h-auto rounded-full ">
            <TextInput class="w-full " v-model="comment" />
            <PrimaryBtn @click.prevent="commentPost">Comment</PrimaryBtn>
        </div>
        <div class="px-4 py-3 overflow-auto" v-memo>
            <div class="mb-4 flex" v-for="comment in comments" :key="`comments${comment.id}`">
                <img :src="comment.user.full_image_path" :alt="comment.user.name" class="w-11 h-11 rounded-full">
                <div class="ml-2 w-full">
                    <div class="flex justify-between w-full items-center">
                        <p class="font-semibold"> {{ comment.user.name }}</p>
                        <div class="flex items-center">
                            <p class="text-gray-900/70">{{ comment.for_humans }}</p>
                            <DropAlt class="ml-2">
                                <button class="dropdownButton" v-if="comment.can.is_comment_owner">
                                    Edit
                                </button>
                            </DropAlt>
                        </div>
                    </div>
                    <p>{{ comment.comment }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { computed, ref } from "vue";
    import { usePage } from "@inertiajs/inertia-vue3";
    import TextInput from "@/Components/TextInput.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import { Inertia } from "@inertiajs/inertia";
    import DropAlt from "@/Components/DropAlt.vue";

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
