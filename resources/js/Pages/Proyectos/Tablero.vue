<script setup>
import {
  mdiProgressCheck,
  mdiProgressPencil,
  mdiProgressClock,
  mdiProgressAlert,
  mdiProgressStar,
  mdiProgressWrench,
  mdiCheckboxMarkedCircleAutoOutline,
} from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import { Head } from "@inertiajs/vue3";
import TipoEstadoTablero from "@/components/Tablero/TipoEstadoTablero.vue";
import IncidenciaTablero from "@/components/Tablero/IncidenciaTablero.vue";

const props = defineProps({
  tablero: String,
  tipoIncidencias: Object,
});

const color = tipo => {
  switch (tipo) {
    case "PENDIENTE":
      return "text-gray-500";

    case "EN_CURSO":
      return "text-blue-500";

    case "AJUSTE":
      return "text-orange-400";

    case "TEST":
      return "text-violet-500";

    case "QA":
      return "text-sky-500";

    case "FINALIZADA":
      return "text-emerald-500";
  }
}

const icono = tipo => {
  switch (tipo) {
    case "PENDIENTE":
      return mdiProgressClock;

    case "EN_CURSO":
      return mdiProgressPencil;

    case "AJUSTE":
      return mdiProgressWrench;

    case "TEST":
      return mdiProgressAlert;

    case "QA":
      return mdiProgressStar;

    case "FINALIZADA":
      return mdiProgressCheck;
  }
}

const cantidad = tipo => {
  return props.tipoIncidencias[tipo].length;
}
</script>

<template>
  <LayoutAuthenticated>

    <Head title="Tableros" />

    <SectionMain>
      <SectionTitleLineWithButton :icon="mdiCheckboxMarkedCircleAutoOutline" :title="'Tablero del proyecto ' + tablero"
        main>
      </SectionTitleLineWithButton>

      <div class="overflow-x-auto overflow-y-auto" style="height: 60vh;">
        <div class="flex gap-4">

          <TipoEstadoTablero v-for="(tipoIncidencia, tipo) in props.tipoIncidencias" :color="color(tipo)"
            :icon="icono(tipo)" :number="cantidad(tipo)" :label="tipo">
            <IncidenciaTablero v-for="incidencia in tipoIncidencia" :title="incidencia.titulo" :code="incidencia.codigo"
              :points="incidencia.puntos" :encarged="incidencia.encargado" />
          </TipoEstadoTablero>
        </div>
      </div>
    </SectionMain>
  </LayoutAuthenticated>
</template>
