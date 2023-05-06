<script setup>
import { useForm, Head } from '@inertiajs/vue3'
import { ref } from 'vue'
import LayoutGuest from '@/layouts/LayoutGuest.vue'
import SectionFullScreen from '@/components/SectionFullScreen.vue'
import CardBox from '@/components/CardBox.vue'
import FormControl from '@/components/FormControl.vue'
import FormField from '@/components/FormField.vue'
import BaseDivider from '@/components/BaseDivider.vue'
import BaseButton from '@/components/BaseButton.vue'
import FormValidationErrors from '@/components/FormValidationErrors.vue'
import IconApp from '@/components/IconApp.vue'

const form = useForm({
  password: ''
})

const passwordInput = ref(null)

const submit = () => {
  form.post(route('password.confirm'), {
    onFinish: () => {
      form.reset()

      passwordInput.value?.focus()
    }
  })
}
</script>

<template>
  <LayoutGuest>
    <Head title="Confirmar contraseña" />
    
    <SectionFullScreen
      v-slot="{ cardClass }"
    >
      <CardBox
        :class="cardClass"
        is-form
        @submit.prevent="submit"
      >
        <FormValidationErrors />

        <IconApp width="w-3/6" />

        <FormField>
          <div class="mb-4 text-sm text-gray-600">
            Esta es un área segura de la aplicación. Por favor, confirme su contraseña antes de continuar.          </div>
        </FormField>

        <FormField
          label="Contraseña"
          label-for="password"
          help="Por favor ingrese su contraseña para confirmar"
        >
          <FormControl
            id="password"
            @set-ref="passwordInput = $event"
            v-model="form.password"
            type="password"
            required
            autocomplete="current-password"
          />
        </FormField>

        <BaseDivider />

        <BaseButton
          type="submit"
          color="info"
          label="Confirm"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        />
      </CardBox>
    </SectionFullScreen>
  </LayoutGuest>
</template>
