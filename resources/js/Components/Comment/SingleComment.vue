<template>
    <div class="mb-4 flex">
        <img :src="comment.user.full_image_path" :alt="comment.user.name" class="w-11 h-11 rounded-full">
        <div class="ml-2 w-full">
            <div class="flex justify-between w-full items-center">
                <div class="">
                    <p class="font-semibold"> {{ comment.user.name }}</p>
                    <p class="text-gray-900/70">{{ comment.for_humans }}</p>
                </div>
                <div class="flex items-center">
                    <DropAlt class="ml-2">
                        <button class="dropdownButton" v-if="comment.can.is_comment_owner"
                                @click.stop="isCommentEditPopUpShown=true">
                            Edit
                        </button>
                        <PopUp :is-shown="isCommentEditPopUpShown" @clicked-outside="isCommentEditPopUpShown=false">
                            <template v-slot:title>
                                Edit your comment
                            </template>
                            <template v-slot:content>
                                <TextInput class="w-96" v-model="editingComment" @keydown.enter="" />
                            </template>
                            <template v-slot:buttons>
                                <PrimaryBtn type="primary" class="mr-3" @click.stop="updateComment">
                                    Save
                                </PrimaryBtn>
                                <PrimaryBtn type="outline" @click.stop="isCommentEditPopUpShown=false">Cancel
                                </PrimaryBtn>
                            </template>
                        </PopUp>
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
                                            @click.stop="deleteComment">
                                    Delete
                                </PrimaryBtn>
                                <PrimaryBtn type="primary" @click.stop="isCommentDeletePopUpShown=false">Cancel
                                </PrimaryBtn>
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
    import { Inertia } from "@inertiajs/inertia";
    import TextInput from "@/Components/TextInput.vue";

    const isCommentDeletePopUpShown = ref(false);
    const isCommentEditPopUpShown = ref(false);
    const editingComment = ref(comment.comment);
    const { comment } = defineProps({
        comment: Object,
    });

    function onFinish(data) {
        if (data.completed) {
            Inertia.reload({ only: ["post"] });
        }
    }

    function updateComment() {
        Inertia.patch(route("comment.update", { id: comment.id }), {
            method: "patch",
            comment: editingComment.value,
        }, {
            onFinish: (data) => {
                if (data.completed) {
                    Inertia.reload({ only: ["post"] });
                }
            },
            preserveState: false,
            preserveScroll: true,
        });
    }

    function deleteComment() {
        Inertia.post(route("comment.destroy", { id: comment.id }), {
            _method: "delete",
        }, {
            onFinish: (data) => {
                if (data.completed) {
                    Inertia.reload({ only: ["post"] });
                }
            },
            preserveScroll: true,
        });
    }
</script>

<style lang="scss" scoped>

</style>
