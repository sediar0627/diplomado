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
import { Head, usePage } from "@inertiajs/vue3";
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

      <CardBox class="mb-6" has-table v-if="usePage().props.auth.proyectos.length > 0">
        <TablaProyectos :proyectos="usePage().props.auth.proyectos" />
      </CardBox>

      <CardBox v-if="usePage().props.auth.proyectos.length == 0">
        <CardBoxComponentEmpty />
      </CardBox>
    </SectionMain>
  </LayoutAuthenticated>
</template>
