<template>{{ posts }}</template>
<script>
import PageLayout from "../Layouts/PageLayout.vue";
export default {
    layout: PageLayout,
};
</script>
<script setup>
defineProps({
    posts: Object,
});
</script>
