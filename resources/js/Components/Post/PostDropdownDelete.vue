<template>
    <a @click.prevent.stop="doesPopUpShow=true"
       class="w-full py-2 px-6 hover:bg-indigo-200/80 active:bg-indigo-300/80 first-of-type:rounded-t-3xl block last-of-type:rounded-b-3xl transition-colors duration-300 cursor-pointer">
        Delete
    </a>
    <PopUp v-if="doesPopUpShow" @cancel="doesPopUpShow=false" @delete="deletePost">
        Are you sure you want to delete?
    </PopUp>
</template>
<script setup>
    import { Inertia } from "@inertiajs/inertia";
    import PopUp from "@/Components/PopUp.vue";
    import { ref } from "vue";

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
        });
    }
</script>
<style>
</style>
