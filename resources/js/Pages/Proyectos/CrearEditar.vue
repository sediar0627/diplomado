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

const props = defineProps({
    proyecto: {
        type: Object,
        default: {
            id: null,
            codigo: '',
            nombre: '',
            descripcion: '',
        },
    },
});

const form = useForm({
    id: props.proyecto.id,
    codigo: props.proyecto.codigo,
    nombre: props.proyecto.nombre,
    descripcion: props.proyecto.descripcion,
});

let seguir_creando = false;

const crearProyecto = () => {
    form.post(route('proyectos.store'), {
        onSuccess: () => {
            usePage().props.succesForm = true;
            form.reset();

            if(! seguir_creando){
                location.href = route('proyectos.index');
            }
        },
        onError: () => {
            usePage().props.succesForm = false;
        },
    });
}

const editarProyecto = () => {
    form.put(route('proyectos.update', props.proyecto?.id ?? '__id'), {
        onSuccess: () => {
            usePage().props.succesForm = true;
        },
        onError: () => {
            usePage().props.succesForm = false;
        },
    });
}

const submit = () => {
    if(! props.proyecto?.id){
        crearProyecto();
    }else{
        editarProyecto();
    }
};

const reset = () => {
    if(! props.proyecto?.id){
        form.reset();
    }
    usePage().props.succesForm = false;
};
</script>

<template>
    <LayoutAuthenticated>
        <Head title="Proyectos" />

        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiBallotOutline" :title="! props.proyecto?.id ? 'Crear proyecto' : 'Actualizar proyecto'" main>
                <BaseButton
                    :href="route('proyectos.index')"
                    :icon="mdiTableBorder"
                    label="Listado de proyectos"
                    color="contrast"
                    rounded-full
                    small
                />
            </SectionTitleLineWithButton>
            
            <CardBox is-form @submit.prevent="submit">

                <FormValidationErrors />

                <FormControl v-if="props.proyecto" v-model="props.proyecto.id" type="hidden" />

                <NotificationBarInCard v-if="usePage().props.succesForm" color="success">
                    {{ ! props.proyecto?.id ? 'Proyecto creado correctamente' : 'Proyecto actualizado correctamente' }}
                </NotificationBarInCard>

                <FormField label="Codigo del proyecto" help="Solo puede contener letras o numeros">
                    <FormControl v-model="form.codigo" type="text" placeholder="Ej: SP" />
                </FormField>

                <FormField label="Nombre del proyecto">
                    <FormControl v-model="form.nombre" type="text" placeholder="Ej: Scrum Pro" />
                </FormField>

                <FormField label="Descripcion del proyecto" help="Caracteres maximos: 250">
                    <FormControl v-model="form.descripcion" type="textarea" placeholder="Ej: Proyecto para gestionar softwares" />
                </FormField>

                <template #footer>
                    <div class="flex gap-4">
                        <BaseButtons>
                            <BaseButton type="submit" color="info" :label="! props.proyecto?.id ? 'Crear' : 'Actualizar'"/>
                            <BaseButton type="button" color="info" outline label="Limpiar" @click="reset"/>
                        </BaseButtons>

                        <FormCheckRadioGroup v-if="! props.proyecto?.id" v-model="seguir_creando" type="switch" 
                            :options="{ true: 'Seguir creando proyectos' }" />
                    </div>
                </template>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>