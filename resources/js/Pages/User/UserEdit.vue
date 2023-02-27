<template>
  <div class="flex flex-col max-w-4xl gap-4 mx-auto md:flex-row">
    <!-- Container for Profile -->
    <div class="static flex md:sticky top-20 md:flex-col md:h-full md:w-1/3">
      <div class="flex md:flex-col rounded-3xl border-gray-500/20 border-[1px] md:mb-3">
        <div class="relative w-1/3 md:w-full">
          <img :src="user.full_image_path" class="w-full rounded-3xl" :alt="`profile picture of ${user.name}`" />
          <button class="absolute bottom-0 right-0 primaryBtn">
            <PencilSquareIcon />
          </button>
        </div>
        <div class="flex flex-col w-2/3 p-3 md:h-full">
          <div>
            <h2 class="text-2xl">{{ user.name }}</h2>
            <p class="mt-2">{{ user.bio ?? "Please add your bio" }}</p>
          </div>
        </div>
      </div>
      <!-- <div class="rounded-3xl border-gray-500/20 border-[1px] md:mb-3 py-3 px-6 hidden md:block">
        <div class="">
          <Link :href="route('user.edit', { user: user.id })" method="get" class="inline-flex items-center primaryBtn">
          <PencilSquareIcon />
          <span class="ml-1">Edit Zuzu</span>
          </Link>
        </div>
      </div> -->
    </div>
    <!-- Section for Profile's posts -->
    <div class="flex flex-col px-3 rounded-3xl md:w-2/3">
      <div class="flex items-center w-full mb-3">
        <div class="w-1/4">
          <label class="font-semibold" for="name">Name</label>
        </div>
        <div class="w-3/4">
          <TextInput id="name" class="w-full" v-model="form.name" />
        </div>
      </div>
      <div class="flex items-center w-full mb-3">
        <div class="w-1/4">
          <label class="font-semibold" for="email">Email</label>
        </div>
        <div class="w-3/4">
          <TextInput id="email" class="w-full" v-model="form.email" />
        </div>
      </div>
      <div class="flex items-start w-full">
        <div class="w-1/4 mt-3">
          <label class="font-semibold" for="bio">Bio</label>
        </div>
        <div class="w-3/4">
          <textarea name="bio" id="bio" rows="4" placeholder="Write something..."
            class="w-full p-4 mb-4 bg-gray-200 border-none resize-none rounded-3xl focus:outline-none"
            v-model="form.bio"></textarea>
        </div>
      </div>
      <button class="w-full primaryBtn" @click="handleForm">

        Save
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
  import PencilSquareIcon from "@/Components/Icons/PencilSquareIcon.vue";
  import TextInput from "@/Components/TextInput.vue";
  import { Link, useForm, router } from "@inertiajs/vue3";
  const props = defineProps<{
    user: object
  }>();
  const form = useForm({
    name: props.user.name,
    email: props.user.email,
    bio: props.user.bio
  })
  function handleForm() {
    form.put(route('user.update', { user: props.user.id }), {
      preserveState: true,
      // onSuccess: function () {
      // router.reload();
      // },
    })
  }
</script>
<script lang="ts">
  import PageLayout from '@/Layouts/PageLayout.vue';
  export default {
    layout: PageLayout,
    components: { TextInput }
  }
</script>