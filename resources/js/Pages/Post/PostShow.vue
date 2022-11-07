<template>
    {{ post }}
</template>

<script setup>
    defineProps({
        post: Object,
    });
</script>
<script>
    import PageLayout from "@/Layouts/PageLayout.vue";

    export default {
        layout: PageLayout,
    };
</script>
<style scoped>

</style>
