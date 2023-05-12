<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import { mdiEmail, mdiFormTextboxPassword } from '@mdi/js'
import LayoutGuest from '@/layouts/LayoutGuest.vue'
import SectionFullScreen from '@/components/SectionFullScreen.vue'
import CardBox from '@/components/CardBox.vue'
import FormField from '@/components/FormField.vue'
import FormControl from '@/components/FormControl.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import BaseButton from '@/components/BaseButton.vue'
import FormValidationErrors from '@/components/FormValidationErrors.vue'
import IconApp from '@/components/IconApp.vue'

const props = defineProps({
  email: {
    type: String,
    default: null
  },
  token: {
    type: String,
    default: null
  }
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

const submit = () => {
  form
    .post(route('password.store'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
  <LayoutGuest>
    <Head title="Restablecer contraseña" />

    <SectionFullScreen
      v-slot="{ cardClass }"
    >
      <CardBox
        :class="cardClass"
        is-form
        @submit.prevent="submit"
      >
        <FormValidationErrors :formulario="form" />

        <IconApp width="w-3/6" />

        <FormField
          label="Correo electrónico"
          label-for="email"
          help="Por favor ingrese su correo electrónico"
        >
          <FormControl
            v-model="form.email"
            :icon="mdiEmail"
            autocomplete="email"
            type="email"
            id="email"
            required
          />
        </FormField>

        <FormField
          label="Contraseña"
          label-for="password"
          help="Por favor ingrese su contraseña"
        >
          <FormControl
            v-model="form.password"
            :icon="mdiFormTextboxPassword"
            type="password"
            autocomplete="new-password"
            id="password"
            required
          />
        </FormField>

        <FormField
          label="Confirm Password"
          label-for="password_confirmation"
          help="Por favor confirme su contraseña"
        >
          <FormControl
            v-model="form.password_confirmation"
            :icon="mdiFormTextboxPassword"
            type="password"
            autocomplete="new-password"
            id="password_confirmation"
            required
          />
        </FormField>

        <BaseDivider />

        <BaseButton
          type="submit"
          color="info"
          label="Restablecer contraseña"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        />
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
