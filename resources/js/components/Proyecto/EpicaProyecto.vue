<script setup>
import { mdiBallotOutline, mdiClose } from "@mdi/js";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, usePage } from '@inertiajs/vue3'
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import axios from "axios";
import { computed } from "vue";

const props = defineProps({
    proyecto: {
        type: Object,
        required: true,
    },
    epicas: {
        type: Array,
        required: true,
    }
});

const epicas = computed(() => props.epicas);

const formEpica = useForm({
    id: null,
    nombre: ''
});

const crearEpica = () => {
    formEpica.post(route('epicas.store', props.proyecto.id), {
        onSuccess: () => {
            usePage().props.succesFormEpica = true;
            formEpica.reset();
        },
        onError: () => {
            usePage().props.succesFormEpica = false;
        },
    });
}

const editarEpica = () => {
    formEpica.put(route('epicas.update', [props.proyecto.id, formEpica?.id ?? '__id']), {
        onSuccess: () => {
            usePage().props.succesFormEpica = true;
            
            props.epicas = props.epicas.map(epica => {
                if(epica.id == formEpica.id) {
                    epica.nombre = formEpica.nombre;
                }
                return epica;
            });

            formEpica.reset();
        },
        onError: () => {
            usePage().props.succesFormEpica = false;
        },
    });
}

let labelButton = computed(() => {
    return formEpica.id ? 'Actualizar' : 'Crear';
})

const submitEpica = () => {
    if(formEpica.id) {
        editarEpica();
    } else {
        crearEpica();
    }
}

const resetEpica = () => {
    formEpica.reset();
    formEpica.clearErrors();
    usePage().props.succesFormEpica = false;
}

const eliminarEpica = (idEpica) => {
    axios
      .delete(route("epicas.destroy", [props.proyecto.id, idEpica]))
      .then(() => {
        usePage().props.succesEliminarEpica = true;
        usePage().props.succesFormEpica = false;

        setTimeout(() => {
            location.reload();
        }, 2000);
      })
      .catch(() => {
        alert("Error al eliminar la epica");
      });
};

</script>

<template>
    <SectionTitleLineWithButton :icon="mdiBallotOutline" title="Epicas del proyecto" main />
            
    <CardBox is-form @submit.prevent="submitEpica">

        <FormValidationErrors :formulario="formEpica"/>

        <NotificationBarInCard v-if="usePage().props.succesFormEpica" color="success" text="Epica Guardada" />

        <NotificationBarInCard v-if="usePage().props.succesEliminarEpica" color="success">
            Epica eliminada
        </NotificationBarInCard>

        <div class="flex flex-wrap gap-4 mb-8">
            <BaseButton
                v-for="epica in epicas"
                :icon="mdiClose"
                :label="epica.nombre"
                color="info"
                rounded-full
                small
                @click="formEpica.id = epica.id; formEpica.nombre = epica.nombre"
                @icon-click="eliminarEpica(epica.id)"
            />
        </div>

        <FormControl v-model="formEpica.id" type="hidden" />

        <FormField label="Nombre de la epica">
            <FormControl v-model="formEpica.nombre" type="text" placeholder="UX / UI" />
        </FormField>

        <template #footer>
            <div class="flex gap-4">
                <BaseButtons>
                    <BaseButton type="submit" color="info" :label="labelButton"/>
                    <BaseButton type="button" color="info" outline label="Limpiar" @click="resetEpica"/>
                </BaseButtons>
            </div>
        </template>
    </CardBox>
</template>
