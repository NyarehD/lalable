<template>
    <form @submit.prevent="submit" class="max-w-4xl mx-auto bg-gray-100 py-4 px-8 rounded-3xl"
          enctype="multipart/form-data">
        <h1 class="text-3xl font-semibold mb-5">Create Post</h1>
        <textarea name="description" id="description" rows="4" placeholder="Write something..."
                  class="w-full rounded-3xl p-4 focus:outline-none border-none bg-gray-200 resize-none"></textarea>
        <div class="grid grid-cols-4 gap-2" v-if="imgList.length!==0">
            <img :src="img" alt="img" v-for="img in imgList" class="h-[12rem] w-full object-cover rounded-3xl">
        </div>
        <div class="flex justify-between">
            <input type="file" class="hidden" id="photoUpload" ref="fileUpload" @input="uploadAndPreviewPhoto" multiple>
            <label for="photoUpload">
                <button class="primaryBtn" @click.prevent="fileUpload.click()">
                    <Media />
                </button>
            </label>
            <button class="primaryBtn">Create Post</button>
        </div>
    </form>
</template>
<script setup>
    import { useForm } from "@inertiajs/inertia-vue3";
    import Media from "@/Components/Icons/Media.vue";
    import { ref } from "vue";

    const imgList = ref([]);
    const fileUpload = ref(null);


    defineProps({
        errors: Object,
    });

    const form = useForm({
        description: "",
        photos: [],
    });

    function uploadAndPreviewPhoto(event) {
        for (let i = 0; i < event.target.files.length; i++) {
            imgList.value.push(URL.createObjectURL(event.target.files[i]));
            form.photos.push(event.target.files[i])
        }
    }

    const submit = () => {
        form.post(route("post.store"), {
            onFinish: () => form.reset("description"),
        });
    };
</script>
<script>
    import PageLayout from "@/Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
