<template>
    <form @submit.prevent="submit" class="max-w-2xl mx-auto bg-gray-100 py-4 px-8 rounded-3xl"
          enctype="multipart/form-data">
        <h1 class="text-3xl font-semibold mb-4">Create Post</h1>
        <textarea name="description" id="description" rows="4" placeholder="Write something..."
                  class="w-full rounded-3xl p-4 focus:outline-none border-none bg-gray-200 resize-none mb-4"
                  v-model="form.description"></textarea>
        <InputError :message="errors.description" v-if="errors.description" />
        <PreviewPhoto :img-list="imgList" :errors="errors" />
        <InputError :message="errors.photos" v-if="errors.photos"/>
        <div class="flex justify-between">
            <input type="file" accept="image/jpeg,image/png" class="hidden" id="photoUpload" ref="fileUpload"
                   @input="uploadAndPreviewPhoto" multiple>
            <label for="photoUpload">
                <PrimaryBtn class="px-3" @click.prevent="fileUpload.click()">
                    <Media />
                </PrimaryBtn>
            </label>
            <PrimaryBtn>Save</PrimaryBtn>
        </div>
    </form>
</template>

<script setup>
    import Media from "@/Components/Icons/Media.vue";
    import InputError from "@/Components/InputError.vue";
    import PreviewPhoto from "@/Components/PreviewPhoto.vue";
    import PrimaryBtn from "@/Components/PrimaryBtn.vue";

    import { useForm } from "@inertiajs/inertia-vue3";
    import { ref } from "vue";
    import { Inertia } from "@inertiajs/inertia";

    const props = defineProps({
        errors: Object,
        post: Object,
    });

    const imgList = ref(props.post.post_photos.map(item => item.photo_src));
    const fileUpload = ref(null);



    const form = useForm({
        description: props.post.description,
        photos: [],
    });

    function uploadAndPreviewPhoto(event) {
        for (let i = 0; i < event.target.files.length; i++) {
            imgList.value.push(URL.createObjectURL(event.target.files[i]));
            form.photos.push(event.target.files[i]);
        }
    }

    const submit = () => {
        Inertia.post(route("post.update", props.post.id), {
            _method: "put",
            description: form.description,
            photos: form.photos,
        });
    };
</script>
<script>
    import PageLayout from "@/Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
<style scoped>

</style>
