<template>
    <div class="dark:bg-zinc-900">
        <NavBar />
        <div class="py-6">
            <slot />
        </div>
    </div>
</template>
<script>
    import NavBar from "@/Components/NavBar/NavBar.vue";
    export default {
        components: { NavBar },
    };
</script>
