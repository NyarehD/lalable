<template>
    <button @click.prevent.stop="doesPopUpShow=true"
            class="dropdownButton">
        Delete
    </button>
    <PopUp :is-shown="doesPopUpShow" @clicked-outside="doesPopUpShow=false">
        <template v-slot:title>
            Are you sure you want to delete?
        </template>
        <template v-slot:buttons>
            <PrimaryBtn type="outline" class="border-red-600 text-red-600 hover:bg-red-600 mr-3"
                        @click.stop="deletePost">
                Delete
            </PrimaryBtn>
            <PrimaryBtn type="primary" @click.stop="doesPopUpShow=false">Cancel</PrimaryBtn>
        </template>
    </PopUp>
</template>
<script setup>
    import { Inertia } from "@inertiajs/inertia";
    import { ref } from "vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";
    import PopUp from "@/Components/PopUp.vue";

    const doesPopUpShow = ref(false);
    const props = defineProps({
        postId: Number,
    });

    function deletePost() {
        Inertia.post(route("post.destroy", { id: props.postId }), {
            _method: "delete",
        }, {
            onFinish: (data) => {
                if (data.completed) {
                    Inertia.reload({ only: ["posts"] });
                }
            },
            preserveScroll: true,
        });
    }
</script>
<style>
</style>
