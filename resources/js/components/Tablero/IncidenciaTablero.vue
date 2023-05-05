<script setup>
import { mdiCog } from "@mdi/js";
import CardBox from "@/components/CardBox.vue";
import NumberDynamic from "@/components/NumberDynamic.vue";
import BaseIcon from "@/components/BaseIcon.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import PillTagTrend from "@/components/PillTagTrend.vue";
import BaseButton from "@/components/BaseButton.vue";

const props = defineProps({
  title: {
    type: String,
    required: true,
  },
  code: {
    type: String,
    required: true,
  },
  points: {
    type: Number,
  },
  encarged: {
    type: String,
  },
});

import { computed } from "vue";

const avatar = computed(
  () =>
    `https://avatars.dicebear.com/api/initials/${props.encarged.replace(
      /[^a-z0-9]+/i,
      "-"
    )}.svg`
);
</script>

<template>
  <CardBox color="bg-gray-200 dark:bg-gray-800 dark:text-white" class="mt-6">
    <p>{{ props.title }}</p>
    <div class="flex justify-between items-center mt-4">
      <div>{{ props.code }}</div>
      <div class="flex items-center gap-4">
        <div v-if="props.points" class="w-8 h-8 flex justify-center items-center rounded-full block max-w-full bg-gray-400 dark:bg-gray-200 dark:text-gray-900">{{ props.points }}</div>
        <div v-if="props.encarged">
          <img
            :src="avatar"
            class="rounded-full w-8 h-8 block bg-gray-100 dark:bg-slate-800"
          />
        </div>
      </div>
    </div>
  </CardBox>
</template>
