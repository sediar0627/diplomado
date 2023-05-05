<script setup>
import { computed } from "vue";

const props = defineProps({
  type : {
    type: String,
    default: 'logo_horizontal'
  },
  width: {
    type: String,
    default: 'w-20'
  }
});

const iconSrc = computed(() => {
  return `/logo/${props.type}.png`;
});

const iconWidth = computed(() => {
  return props.width;
});
</script>

<template>
  <figure class="flex justify-center items-center">
    <img :class="iconWidth" :src="iconSrc" alt="Scrum Pro" >
  </figure>
</template>
