<template>
    <div class="">
        <NavBar />
        <h1>This is layout</h1>
        <slot />
    </div>
</template>
<script>
import NavBar from "@/Components/NavBar/NavBar.vue";
export default {
    components: { NavBar },
};
</script>
