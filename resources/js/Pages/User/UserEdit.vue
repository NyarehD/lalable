<template>
  <div class="md:flex-row flex flex-col max-w-4xl min-h-screen gap-4 mx-auto">
    <!-- Container for Profile -->
    <div class="md:sticky top-20 md:flex-col md:h-full md:w-1/3 static flex">
      <div class="flex md:flex-col rounded-3xl border-gray-500/20 border-[1px] md:mb-3">
        <div class="md:w-full relative w-1/3">
          <img :src="previewProfilePhoto || user.full_image_path"
            class="aspect-square rounded-3xl object-cover w-full h-full" :alt="`profile picture of ${user.name}`" />
          <button class="absolute bottom-0 left-0 px-3 md:px-4 md:py-2.5 primaryBtn" @click="profilePictureInput.click">
            <PencilSquareIcon class="md:h-6 h-4" />
          </button>
          <input type="file" accept="image/jpeg,image/png" class="hidden" id="profilePicture" ref="profilePictureInput"
            @input="handleProfileInput">
          <div class="absolute bottom-0 right-0">
            <button class="primaryBtn mr-1" v-show="showSaveProfilePhoto" @click="submitProfilePicture">Save</button>
            <button class="primaryBtn hover:bg-red-700 bg-red-600" v-show="showSaveProfilePhoto"
              @click="removePreviewPhoto">Cancel</button>
          </div>
        </div>
        <div class="md:h-full md:p-4 flex flex-col w-2/3 p-3">
          <div>
            <h2 class="dark:text-white text-2xl">{{ user.name }}</h2>
            <p class="dark:text-white mt-2">{{ user.bio ?? "Please add your bio" }}</p>
          </div>
        </div>
      </div>
    </div>
    <!-- Section for Profile's posts -->
    <div class="rounded-3xl md:w-2/3 flex flex-col px-3">
      <div class="flex items-center w-full mb-3">
        <div class="w-1/4">
          <label class="dark:text-white font-semibold" for="name">Name</label>
        </div>
        <div class="w-3/4">
          <TextInput id="name"
            class="dark:bg-neutral-700 dark:text-white dark:placeholder:text-white/70 dark:caret-white w-full"
            v-model="form.name" />
        </div>
      </div>
      <div class="flex items-center w-full mb-3">
        <div class="w-1/4">
          <label class="dark:text-white font-semibold" for="email">Email</label>
        </div>
        <div class="w-3/4">
          <TextInput id="email"
            class="dark:bg-neutral-700 dark:text-white dark:placeholder:text-white/70 dark:caret-white w-full"
            v-model="form.email" />
        </div>
      </div>
      <div class="flex items-start w-full">
        <div class="w-1/4 mt-3">
          <label class="dark:text-white font-semibold" for="bio">Bio</label>
        </div>
        <div class="w-3/4">
          <textarea name="bio" id="bio" rows="4" placeholder="Write something..."
            class="rounded-3xl dark:bg-neutral-700 dark:text-white dark:placeholder:text-white/70 dark:caret-white focus:outline-none w-full p-4 mb-4 bg-gray-200 border-none resize-none"
            v-model="form.bio"></textarea>
        </div>
      </div>
      <button class="primaryBtn w-full" @click="handleForm">
        Save
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import PencilSquareIcon from "@/Components/Icons/PencilSquareIcon.vue";
  import TextInput from "@/Components/TextInput.vue";
  import User from "@/Types/user.type";
  import { useForm } from "@inertiajs/vue3";


  const profilePictureInput = ref<HTMLInputElement>();
  const previewProfilePhoto = ref<string | null>(null);
  const showSaveProfilePhoto = ref(false);
  const props = defineProps<{
    user: User
  }>();

  const form = useForm({
    name: props.user.name,
    email: props.user.email,
    bio: props.user.bio,
  })
  const profilePictureForm = useForm({
    profile_picture: null
  })

  function handleForm() {
    form.patch(route('user.update', { user: props.user.id }), {
      preserveState: true,
    })
  }

  function handleProfileInput(event: Event) {
    const target = event.target as HTMLInputElement;
    const file = target.files as FileList;

    showSaveProfilePhoto.value = true;
    previewProfilePhoto.value = URL.createObjectURL(file[0]);
    profilePictureForm.profile_picture = file[0];
  }
  function submitProfilePicture() {
    if (profilePictureForm.profile_picture !== null) {
      profilePictureForm.post(route('user.updateProfilePicture', { user: props.user.id }), {
        onSuccess: () => {
          showSaveProfilePhoto.value = false;
          previewProfilePhoto.value = null;
          profilePictureForm.reset();
        },
      })
    }
  }
  function removePreviewPhoto() {
    previewProfilePhoto.value = null;
    showSaveProfilePhoto.value = false;
  }
</script>
<script lang="ts">
  import PageLayout from '@/Layouts/PageLayout.vue';
  import { ref } from "vue";
  export default {
    layout: PageLayout,
    components: { TextInput }
  }
</script>