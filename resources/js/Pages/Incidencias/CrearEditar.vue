<script setup>
import { mdiBallotOutline, mdiTableBorder } from "@mdi/js";
import SectionMain from "@/components/SectionMain.vue";
import CardBox from "@/components/CardBox.vue";
import FormCheckRadioGroup from "@/components/FormCheckRadioGroup.vue";
import FormField from "@/components/FormField.vue";
import FormControl from "@/components/FormControl.vue";
import BaseButton from "@/components/BaseButton.vue";
import BaseButtons from "@/components/BaseButtons.vue";
import LayoutAuthenticated from "@/layouts/LayoutAuthenticated.vue";
import SectionTitleLineWithButton from "@/components/SectionTitleLineWithButton.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import { useForm, Head, usePage } from '@inertiajs/vue3'
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import { computed } from "vue";

const props = defineProps({
    proyecto: {
        type: Object,
        required: true,
    },
    incidencia: {
        type: Object,
        default: {
            id: null,
            sprint_id: '',
            titulo: '',
            descripcion: '',
            epica_id: '',
            puntaje: '',
            responsable_id: '',
        },
    },
    epicas: {
        type: Array,
        default: [],
    },
    usuariosInvitados: {
        type: Array,
        default: [],
    },
});

const epicas = [
    { value: null, label: 'Sin asignar' },
].concat(
    props.epicas.map(epica => (
        { value: epica.id, label: epica.nombre }
    ))
);

const usuariosInvitados = [
    { value: null, label: 'Sin asignar' },
    { value: usePage().props.auth.user.id, label: usePage().props.auth.user.name + ' - TU' }
].concat(
    props.usuariosInvitados.map(usuario => (
        { value: usuario.id, label: usuario.name }
    ))
);

const form = useForm({
    id: props.incidencia.id,
    sprint_id: props.incidencia.sprint_id,
    titulo: props.incidencia.titulo,
    descripcion: props.incidencia.descripcion,
    epica_id: props.incidencia.epica_id,
    puntaje: props.incidencia.puntaje,
    responsable_id: props.incidencia.responsable_id,
});

let seguir_creando = false;

const crearIncidencia = () => {
    form.post(route('incidencias.store', props.proyecto.id), {
        onSuccess: () => {
            usePage().props.succesForm = true;
            form.reset();

            if(! seguir_creando){
                location.href = route('incidencias.index', props.proyecto.id);
            }
        },
        onError: () => {
            usePage().props.succesForm = false;
        },
    });
}

const editarIncidencia = () => {
    form.put(route('incidencias.update', [props.proyecto.id, props.incidencia?.id ?? '__id']), {
        onSuccess: () => {
            usePage().props.succesForm = true;
        },
        onError: () => {
            usePage().props.succesForm = false;
        },
    });
}

const submit = () => {
    if(! props.incidencia?.id){
        crearIncidencia();
    }else{
        editarIncidencia();
    }
};

const reset = () => {
    if(! props.incidencia?.id){
        form.reset();
    }
    usePage().props.succesForm = false;
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Incidencias" />

        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="! props.incidencia?.id ? 'Crear incidencia' : 'Actualizar incidencia'" main>
                <BaseButton
                    :href="route('incidencias.index', props.proyecto.id)"
                    :icon="mdiTableBorder"
                    label="Listado de incidencias"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            
            <CardBox is-form @submit.prevent="submit">

                <FormValidationErrors :formulario="form"/>

                <FormControl v-if="props.incidencia?.id" v-model="props.incidencia.id" type="hidden" />

                <NotificationBarInCard v-if="usePage().props.succesForm" color="success">
                    {{ ! props.incidencia?.id ? 'Incidencia creada correctamente' : 'Incidencia actualizada correctamente' }}
                </NotificationBarInCard>

                <FormField label="Titulo de la incidencia">
                    <FormControl v-model="form.titulo" type="text" placeholder="Ej: Creacion del login" />
                </FormField>

                <FormField label="Epica">
                    <FormControl v-model="form.epica_id" :options="epicas" />
                </FormField>

                <FormField label="Responsable">
                    <FormControl v-model="form.responsable_id" :options="usuariosInvitados" />
                </FormField>

                <FormField label="Descripcion del incidencia">
                    <FormControl v-model="form.descripcion" type="textarea" placeholder="Ej: Se desea que la aplicacion pueda loguearse por correo y contraseña" />
                </FormField>

                <template #footer>
                    <div class="flex gap-4">
                        <BaseButtons>
                            <BaseButton type="submit" color="info" :label="! props.incidencia?.id ? 'Crear' : 'Actualizar'"/>
                            <BaseButton type="button" color="info" outline label="Limpiar" @click="reset"/>
                        </BaseButtons>

                        <FormCheckRadioGroup v-if="! props.incidencia?.id" v-model="seguir_creando" type="switch" 
                            :options="{ true: 'Seguir creando incidencias' }" />
                    </div>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
