<template>
    <button @click.prevent.stop="doesPopUpShow=true"
            class="dropdownButton">
        Delete
    </button>
    <Teleport to="body">
        <div v-if="doesPopUpShow"
             class="fixed rounded-3xl bg-white/95 backdrop-blur-2xl p-8 top-1/3 left-1/2 -translate-x-1/2 w-96 drop-shadow-2xl">
            <h2 class="text-lg text-center font-semibold mb-5">
                Are you sure you want to delete?
            </h2>
            <div class="flex justify-end">
                <PrimaryBtn type="outline" class="border-red-600 text-red-600 hover:bg-red-600 mr-3"
                            @click.stop="deletePost">
                    Delete
                </PrimaryBtn>
                <PrimaryBtn @click.stop="doesPopUpShow=false">Cancel</PrimaryBtn>
            </div>
        </div>
    </Teleport>
</template>
<script setup>
    import { Inertia } from "@inertiajs/inertia";
    import { ref } from "vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";

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
