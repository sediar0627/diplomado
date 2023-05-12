<script setup>
import { computed, ref } from "vue";
import { mdiTrashCan, mdiPencilBox, mdiEye } from "@mdi/js";
import CardBoxModal from "@/components/CardBoxModal.vue";
import BaseLevel from "@/components/BaseLevel.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import BaseButton from "@/components/BaseButton.vue";
import axios from "axios";
import { usePage } from "@inertiajs/vue3";

const proyectos = computed(() => usePage().props.auth.proyectos);

const porPagina = ref(5);

const paginaActual = ref(0);

const proyectosPaginados = computed(() =>
  proyectos.value.slice(
    porPagina.value * paginaActual.value,
    porPagina.value * (paginaActual.value + 1)
  )
);

const cantidadPaginas = computed(() => Math.ceil(proyectos.value.length / porPagina.value));

const paginaActualVista = computed(() => paginaActual.value + 1);

const listadoPaginas = computed(() => {
  const listadoPaginas = [];

  for (let i = 0; i < cantidadPaginas.value; i++) {
    listadoPaginas.push(i);
  }

  return listadoPaginas;
});

const modalEliminadoActivo = ref(false);

let proyectoEliminarId = null;

const confirmarEliminado = () => {
  if (proyectoEliminarId) {
    axios
      .delete(route("proyectos.destroy", proyectoEliminarId))
      .then(() => {
        location.reload();
      })
      .catch(() => {
        alert("Error al eliminar el proyecto");
      });
  }
};

const cancelarEliminado = () => {
  proyectoEliminarId = null;
};

const modalEliminado = proyecto => {
  document.getElementById('contenidoEliminarProyecto').innerHTML = `
      ¿ Esta seguro que desea eliminar el proyecto <strong>${proyecto.codigo} - ${proyecto.nombre}</strong> ?
    `;

  proyectoEliminarId = proyecto.id;
};

</script>

<template>
  <CardBoxModal v-model="modalEliminadoActivo" title="Por favor confirme" button="danger" has-cancel
    @confirm="confirmarEliminado" @cancel="cancelarEliminado">
    <p id="contenidoEliminarProyecto"></p>
  </CardBoxModal>

  <table>
    <thead>
      <tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="proyecto in proyectosPaginados" :key="proyecto.id">
        <td data-label="Codigo">
          {{ proyecto.codigo }}
        </td>
        <td data-label="Nombre">
          {{ proyecto.nombre }}
        </td>
        <td data-label="Descripcion">
          {{ proyecto.descripcion }}
        </td>
        <td class="before:hidden lg:w-1 whitespace-nowrap">
          <BaseButtons type="justify-start lg:justify-end" no-wrap>
            <BaseButton color="warning" :icon="mdiEye" small :href="route('proyectos.dashboard', proyecto.id)" />
            <BaseButton v-if="proyecto.creador_id == usePage().props.auth.user.id" color="info" :icon="mdiPencilBox" small :href="route('proyectos.edit', proyecto.id)" />
            <BaseButton v-if="proyecto.creador_id == usePage().props.auth.user.id" color="danger" :icon="mdiTrashCan" small
              @click="modalEliminado(proyecto); modalEliminadoActivo = true;" />
          </BaseButtons>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="p-3 lg:px-6 border-t border-gray-100 dark:border-slate-800">
    <BaseLevel>
      <BaseButtons>
        <BaseButton v-for="page in listadoPaginas" :key="page" :active="page === paginaActual" :label="page + 1"
          :color="page === paginaActual ? 'lightDark' : 'whiteDark'" small @click="paginaActual = page" />
      </BaseButtons>
      <small>Pagina {{ paginaActualVista }} de {{ cantidadPaginas }}</small>
    </BaseLevel>
  </div>
</template>
