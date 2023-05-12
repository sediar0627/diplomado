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

const props = defineProps({
    proyecto: {
        type: Object,
        required: true,
    },
    usuariosInvitados: {
        type: Array,
        required: true,
    }
});

const formEnviarInvitacion = useForm({
    correo: ''
});

const submitInvitacion = () => {
    formEnviarInvitacion.post(route('proyectos.enviar_invitacion', props.proyecto?.id ?? '__id'), {
        onSuccess: () => {
            usePage().props.succesFormEnviarInvitacion = true;
            formEnviarInvitacion.reset();
        },
        onError: () => {
            usePage().props.succesFormEnviarInvitacion = false;
        },
    });
}

const resetInvitacion = () => {
    formEnviarInvitacion.reset();
    formEnviarInvitacion.clearErrors();
    usePage().props.succesFormEnviarInvitacion = false;
}

const eliminarInvitacion = idUsuarioInvitado => {
    axios
      .delete(route("proyectos.eliminar_invitacion", [props.proyecto?.id ?? '__id', idUsuarioInvitado]))
      .then(() => {
        usePage().props.succesEliminarInvitacion = true;
        setTimeout(() => {
            location.reload();
        }, 2000);
      })
      .catch(() => {
        alert("Error al eliminar el proyecto");
      });
};

</script>

<template>
    <SectionTitleLineWithButton :icon="mdiBallotOutline" title="Usuarios del proyecto" main />
            
    <CardBox is-form @submit.prevent="submitInvitacion">

        <FormValidationErrors :formulario="formEnviarInvitacion"/>

        <NotificationBarInCard v-if="usePage().props.succesFormEnviarInvitacion" color="success">
            Invitacion enviada
        </NotificationBarInCard>

        <NotificationBarInCard v-if="usePage().props.succesEliminarInvitacion" color="success">
            Usuario eliminado
        </NotificationBarInCard>

        <div class="flex flex-wrap gap-4 mb-8">
            <BaseButton
                v-for="usuarioInvitado in props.usuariosInvitados"
                :icon="mdiClose"
                :label="usuarioInvitado.email"
                color="info"
                rounded-full
                small
                @icon-click="eliminarInvitacion(usuarioInvitado.id)"
            />
        </div>

        <FormField label="Correo del usuario">
            <FormControl v-model="formEnviarInvitacion.correo" type="email" placeholder="Ej: janedoe@gmail.com" />
        </FormField>

        <template #footer>
            <div class="flex gap-4">
                <BaseButtons>
                    <BaseButton type="submit" color="info" label="Enviar invitacion"/>
                    <BaseButton type="button" color="info" outline label="Limpiar" @click="resetInvitacion"/>
                </BaseButtons>
            </div>
        </template>
    </CardBox>
</template>
