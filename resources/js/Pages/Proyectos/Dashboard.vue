<script setup>
import { computed, ref, onMounted } from "vue";
import {
  mdiProgressCheck,
  mdiProgressPencil,
  mdiProgressClock,
  mdiProgressAlert,
  mdiProgressStar,
  mdiProgressWrench,
  mdiCheckboxMarkedCircleAutoOutline,
  mdiReload,
  mdiChartPie,
} from "@mdi/js";
import * as chartConfig from "@/components/Charts/chart.config.js";
import LineChart from "@/components/Charts/LineChart.vue";
import SectionMain from "@/components/SectionMain.vue";
import CardBoxWidget from "@/components/CardBoxWidget.vue";
import CardBox from "@/components/CardBox.vue";
import BaseButton from "@/components/BaseButton.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
  proyecto: {
    type: Object,
    required: true,
  },
  cantidadIncidenciasPorEstado: {
    type: Array,
    required: true,
  },
});

const chartData = ref(null);

const fillChartData = () => {
  chartData.value = chartConfig.rendimientoTareas();
};

onMounted(() => {
  fillChartData();
});
</script>

<template>
  <LayoutAuthenticated>
    <Head title="Dashboard" />
    
    <SectionMain>
      <SectionTitleLineWithButton
        :icon="mdiCheckboxMarkedCircleAutoOutline"
        :title="'Tareas del proyecto ' + proyecto.nombre"
        main
      >
      </SectionTitleLineWithButton>

      <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
        <CardBoxWidget
          color="text-gray-500"
          :icon="mdiProgressClock"
          :number="props.cantidadIncidenciasPorEstado.PENDIENTE"
          label="Pendientes"
        />
        <CardBoxWidget
          color="text-blue-500"
          :icon="mdiProgressPencil"
          :number="props.cantidadIncidenciasPorEstado.EN_CURSO"
          label="En curso"
        />
        <CardBoxWidget
          color="text-orange-400"
          :icon="mdiProgressWrench"
          :number="props.cantidadIncidenciasPorEstado.AJUSTE"
          label="Ajustes"
        />
        <CardBoxWidget
          color="text-violet-500"
          :icon="mdiProgressAlert"
          :number="props.cantidadIncidenciasPorEstado.TEST"
          label="Test"
        />
        <CardBoxWidget
          color="text-sky-500"
          :icon="mdiProgressStar"
          :number="props.cantidadIncidenciasPorEstado.QA"
          label="QA"
        />
        <CardBoxWidget
          color="text-emerald-500"
          :icon="mdiProgressCheck"
          :number="props.cantidadIncidenciasPorEstado.FINALIZADA"
          label="Finalizada"
        />
      </div>

      <SectionTitleLineWithButton :icon="mdiChartPie" title="Rendimiento de tareas">
        <BaseButton
          :icon="mdiReload"
          color="whiteDark"
          @click="fillChartData"
        />
      </SectionTitleLineWithButton>

      <CardBox class="mb-6">
        <div v-if="chartData">
          <line-chart :data="chartData" class="h-96" />
        </div>
      </CardBox>

    </SectionMain>
  </LayoutAuthenticated>
</template>
