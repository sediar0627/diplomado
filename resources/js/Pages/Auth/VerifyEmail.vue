<script setup>
import { useForm, Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import LayoutGuest from "@/layouts/LayoutGuest.vue";
import SectionFullScreen from "@/components/SectionFullScreen.vue";
import CardBox from "@/components/CardBox.vue";
import FormField from "@/components/FormField.vue";
import BaseDivider from "@/components/BaseDivider.vue";
import BaseButton from "@/components/BaseButton.vue";
import FormValidationErrors from "@/components/FormValidationErrors.vue";
import NotificationBarInCard from "@/components/NotificationBarInCard.vue";
import BaseLevel from "@/components/BaseLevel.vue";

const props = defineProps({
  status: {
    type: String,
    default: null,
  },
});

const form = useForm({});

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);

const submit = () => {
  form.post(route("verification.send"));
};
</script>

<template>
  <LayoutGuest>
    <Head title="Email Verification" />

    <SectionFullScreen v-slot="{ cardClass }">
      <CardBox :class="cardClass" is-form @submit.prevent="submit">
        <FormValidationErrors :formulario="form"/>

        <NotificationBarInCard v-if="verificationLinkSent" color="info">
          Se ha enviado un nuevo enlace de verificación a la dirección de correo electrónico que proporcionó durante el registro.
        </NotificationBarInCard>

        <FormField>
          <div class="mb-4 text-sm text-gray-600">
            Gracias por registrarte! Antes de comenzar, ¿podría verificar su dirección de correo electrónico haciendo clic en el enlace que le acabamos de enviar? Si no recibiste el correo electrónico, con gusto te enviaremos otro.
          </div>
        </FormField>

        <BaseDivider />

        <BaseLevel>
          <BaseButton
            type="submit"
            color="info"
            label="Resend Verification Email"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          />
          <Link :href="route('logout')" method="post" as="button">
            Cerar sesión
          </Link>
        </BaseLevel>
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
