<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import NotificationBar from "@/components/NotificationBar.vue";

const hasFlashMessage = computed(() => {
  return (
    usePage().props.flash.success ||
    usePage().props.flash.info ||
    usePage().props.flash.warning ||
    usePage().props.flash.danger
  );
});

const color = computed(() => {
  if (usePage().props.flash.success) {
    return "success";
  } else if (usePage().props.flash.info) {
    return "info";
  } else if (usePage().props.flash.warning) {
    return "warning";
  } else if (usePage().props.flash.danger) {
    return "danger";
  }
});

const message = computed(() => {
  if (usePage().props.flash.success) {
    return usePage().props.flash.success;
  } else if (usePage().props.flash.info) {
    return usePage().props.flash.info;
  } else if (usePage().props.flash.warning) {
    return usePage().props.flash.warning;
  } else if (usePage().props.flash.danger) {
    return usePage().props.flash.danger;
  }
});
</script>

<template>
  <section v-if="hasFlashMessage" class="p-6 xl:max-w-6xl xl:mx-auto">
    <NotificationBar :color="color">
      {{ message }}
    </NotificationBar>
  </section>
</template>
