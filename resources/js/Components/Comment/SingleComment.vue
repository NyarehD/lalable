<template>
    <div class="flex">
        <img :src="comment.user.full_image_path" :alt="comment.user.name" class="rounded-full w-11 h-11">
        <div class="w-full ml-2">
            <div class="flex items-center justify-between w-full">
                <div class="">
                    <p class="font-semibold"> {{ comment.user.name }}</p>
                    <p class="text-gray-900/70">{{ comment.for_humans }}</p>
                </div>
                <div class="flex items-center">
                    <DropAlt class="ml-2">
                        <!--                        Comment Edit-->
                        <button class="dropdownButton" v-if="$page.props.auth.user.id === comment.user.id"
                            @click.stop="isCommentEditPopUpShown = true">
                            Edit
                        </button>
                        <PopUp :is-shown="isCommentEditPopUpShown" @clicked-outside="isCommentEditPopUpShown = false">
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
                                <PrimaryBtn type="outline" @click.stop="isCommentEditPopUpShown = false">Cancel
                                </PrimaryBtn>
                            </template>
                        </PopUp>
                        <!--End of Comment Edit-->
                        <!--Comment Reply-->
                        <button class="dropdownButton" @click="isCommentReplyPopUpShown = true">
                            Reply
                        </button>
                        <PopUp :is-shown="isCommentReplyPopUpShown" @clicked-outside="isCommentReplyPopUpShown = false">
                            <template v-slot:title>
                                Reply to {{ comment.user.name }}
                            </template>
                            <template v-slot:content>
                                <TextInput class="w-96" v-model="replyingComment" @keydown.enter="replyComment" />
                            </template>
                            <template v-slot:buttons>
                                <PrimaryBtn type="primary" class="mr-3" @click.stop="replyComment">
                                    Reply
                                </PrimaryBtn>
                                <PrimaryBtn type="outline" @click.stop="isCommentReplyPopUpShown = false">Cancel
                                </PrimaryBtn>
                            </template>
                        </PopUp>
                        <!--End of Comment Reply-->
                        <!--Comment Delete-->
                        <button class="dropdownButton" v-if="$page.props.auth.user.id === comment.user.id"
                            @click="isCommentDeletePopUpShown = true">
                            Delete
                        </button>
                        <PopUp :is-shown="isCommentDeletePopUpShown"
                            @clicked-outside="isCommentDeletePopUpShown = false">
                            <template v-slot:title>
                                Are you sure you want to delete the comment?
                            </template>
                            <template v-slot:buttons>
                                <PrimaryBtn type="outline" class="mr-3 text-red-600 border-red-600 hover:bg-red-600"
                                    @click.stop="deleteComment">
                                    Delete
                                </PrimaryBtn>
                                <PrimaryBtn type="primary" @click.stop="isCommentDeletePopUpShown = false">Cancel
                                </PrimaryBtn>
                            </template>
                        </PopUp>
                        <!--                        End of Comment Delete-->
                    </DropAlt>
                </div>
            </div>
            <p class="mb-4">{{ comment.comment }}</p>
            <div v-if="comment.replies">
                <SingleComment v-for="reply in comment.replies" :key="`replies${comment.id}${reply.id}`"
                    :comment="reply" />
            </div>
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

    const { comment } = defineProps({
        comment: Object,
    });

    const isCommentDeletePopUpShown = ref(false);
    const isCommentEditPopUpShown = ref(false);
    const isCommentReplyPopUpShown = ref(false);
    const editingComment = ref(comment.comment);
    const replyingComment = ref("");

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

    function replyComment() {
        Inertia.post(route("comment.store"), {
            "comment": replyingComment.value,
            "post_id": comment.post_id,
            "parent_id": comment.id,
        }, {
            preserveScroll: true,
            preserveState: false,
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

<style lang="scss" scoped></style>
