<template>
  <div class="fixed px-4 py-2 text-white bg-green-600/95 bottom-4 right-4 rounded-3xl drop-shadow-2xl" :class="{}">
    {{ $props.text }}
  </div>
</template>
<script setup>
  defineProps({
    text: {
      required: true,
      type: String
    }
  })
</script>