<script setup>
import {
  mdiTableBorder,
  mdiPlus,
} from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import BaseButton from "@/components/BaseButton.vue";
import CardBoxComponentEmpty from "@/components/CardBoxComponentEmpty.vue";
import TablaProyectos from "@/components/Proyecto/TablaProyectos.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  proyectos: {
    type: Array,
    required: true,
  },
});
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Proyectos" />
    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiTableBorder" title="Listado de proyectos" main >
        <BaseButton
          :href="route('proyectos.create')"
          :icon="mdiPlus"
          label="Crear proyecto"
          color="contrast"
          rounded-full
          small
        />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6" has-table v-if="props.proyectos.length > 0">
        <TablaProyectos :proyectos="props.proyectos" />
      </CardBox>

      <CardBox v-if="props.proyectos.length == 0">
        <CardBoxComponentEmpty />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
