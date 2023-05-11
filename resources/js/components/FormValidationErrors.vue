<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";

const props = defineProps({
  formulario: {
    type: Object,
    required: true
  }
});

const errors = computed(() => props.formulario.errors);

const tieneErrores = computed(() => props.formulario.hasErrors)
</script>

<template>
  <NotificationBarInCard v-if="tieneErrores" color="danger">
    <b>¡Vaya! Algo salió mal.</b>
    <span v-for="error in errors">{{ error }}</span>
  </NotificationBarInCard>
</template>
