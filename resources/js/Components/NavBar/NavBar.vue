<template>
    <header
        class="sticky inset-0 z-10 bg-white drop-shadow-xl dark:bg-neutral-800"
    >
        <div
            class="customContainer flex h-16 items-center justify-between px-3 dark:bg-neutral-800 md:h-20"
        >
            <a href="/" class="block">
                <img
                    alt="Pokemon Logo"
                    src="/Pokemon_International.svg"
                    class="h-14 w-full"
                />
            </a>
            <div class="flex flex-1 items-center justify-end">
                <nav class="hidden md:block" aria-label="header-navigation">
                    <ul class="text-co flex items-center gap-4 text-sm">
                        <li>
                            <NavBarLink route-name="pokedex"
                                >Pokedex</NavBarLink
                            >
                        </li>
                        <li>
                            <NavBarLink route-name="about">About</NavBarLink>
                        </li>
                        <li>
                            <DarkModeButton />
                        </li>
                    </ul>
                </nav>
                <DarkModeButton class="mx-3 md:hidden" />
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
                        <NavBarLink route-name="pokedex" @click="toggleNavBar">
                            Pokedex
                        </NavBarLink>
                    </li>
                    <li class="h-10 w-full text-center align-middle">
                        <NavBarLink route-name="about" @click="toggleNavBar">
                            About
                        </NavBarLink>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>

<script setup lang="ts">
import { ref } from "vue";
import NavBarLink from "./NavBarLink.vue";
import NavBarToggleBtn from "./NavBarToggleBtn.vue";
import DarkModeButton from "./DarkModeButton.vue";

const navBarToggle = ref(false);

function toggleNavBar() {
    navBarToggle.value = !navBarToggle.value;
}
</script>

<style scoped lang="scss">
.navMobile {
    transform: translateY(-100 + 4rem);
}

.navMobile.appear {
    transform: translateY(0);
}
</style>
