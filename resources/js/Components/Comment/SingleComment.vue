<template>
    <div class="mb-4 flex">
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
                        <button class="dropdownButton" v-if="comment.can.is_comment_owner"
                                @click="isCommentDeletePopUpShown=true">
                            Delete
                        </button>
                        <PopUp :is-shown="isCommentDeletePopUpShown" @clicked-outside="isCommentDeletePopUpShown=false">
                            <template v-slot:title>
                                Are you sure you want to delete the comment?
                            </template>
                            <template v-slot:buttons>
                                <PrimaryBtn type="outline" class="border-red-600 text-red-600 hover:bg-red-600 mr-3"
                                            @click.stop="deletePost">
                                    Delete
                                </PrimaryBtn>
                                <PrimaryBtn @click.stop="isCommentDeletePopUpShown=false">Cancel</PrimaryBtn>
                            </template>
                        </PopUp>
                    </DropAlt>
                </div>
            </div>
            <p>{{ comment.comment }}</p>
        </div>
    </div>
</template>

<script setup>
    import DropAlt from "@/Components/DropAlt.vue";
    import PopUp from "@/Components/PopUp.vue";
    import { ref } from "vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";

    const isCommentDeletePopUpShown = ref(false);
    defineProps({
        comment: Object,
    });
</script>

<style lang="scss" scoped>

</style>
