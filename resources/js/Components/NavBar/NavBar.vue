<template>
    <header class="sticky inset-0 z-10 bg-white drop-shadow-xl dark:bg-neutral-800">
        <div
            class="flex max-w-2xl md:max-w-[75rem] items-center justify-between px-3 dark:bg-neutral-800 h-16 mx-auto ">
            <a href="/" class="block">
                <img
                    alt="Pokemon Logo"
                    src="/Pokemon_International.svg"
                    class="h-10 w-full"
                />
            </a>
            <div class="bg-indigo-300 rounded-full h-9 px-3 pl-5 relative">
                <span class="absolute inset-y-0 left-0 grid place-content-center ml-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </span>
                <input class="w-full pr-10 bg-transparent focus:outline-none mt-1 ml-7">
            </div>
            <div class="flex items-center justify-end w-auto">
                <div class="hidden md:blockmr-3">
                    <Link
                        class="inline-flex items-center primaryBtn"
                        href="post/create">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                        </svg>
                        <span class="ml-1">Post</span>
                    </Link>
                </div>
                <DarkModeButton class="mr-3" />
                <div class="mr-3" v-if="user">
                    <img :src="user.full_image_path" :alt="user.name" class="w-11 h-auto rounded-full">
                </div>
                <NavBarToggleBtn
                    @click="navBarToggle = !navBarToggle"
                    :toggle-status="navBarToggle"
                />
            </div>
        </div>
        <div
            class="navMobile absolute -z-10 mx-auto w-full max-w-screen-xl bg-white px-4 pb-4 transition-all duration-300 dark:bg-neutral-800 md:hidden md:px-8"
            :class="{ appear: navBarToggle }"
        >
            <nav class="" aria-label="header-navigation">
                <ul class="text-co flex flex-col items-center text-sm">
                    <li class="h-10 w-full text-center align-middle">
                        <NavBarLink link="pokedex" @click="toggleNavBar">
                            Pokedex
                        </NavBarLink>
                    </li>
                    <li class="h-10 w-full text-center align-middle">
                        <NavBarLink link="about" @click="toggleNavBar">
                            About
                        </NavBarLink>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script setup lang="ts">
    import { computed, ref } from "vue";
    import NavBarLink from "./NavBarLink.vue";
    import NavBarToggleBtn from "./NavBarToggleBtn.vue";
    import DarkModeButton from "./DarkModeButton.vue";
    import { Link, usePage } from "@inertiajs/inertia-vue3";

    const navBarToggle = ref(false);

    function toggleNavBar() {
        navBarToggle.value = !navBarToggle.value;
    }

    const user = computed(() => usePage().props.value.auth.user);
</script>

<style scoped lang="scss">
    .navMobile {
        transform: translateY(-100 + 4rem);
    }

    .navMobile.appear {
        transform: translateY(0);
    }
</style>
