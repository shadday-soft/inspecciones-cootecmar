<template>
  <AppLayout title="Editar Permiso">
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Editar Permiso: {{ permission.name }}</h1>
        <p class="text-gray-600 mt-2">Modifica la información del permiso.</p>
      </div>

      <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <form @submit.prevent="submitForm" class="px-4 py-6 sm:p-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <!-- Nombre del permiso -->
            <div class="sm:col-span-4">
              <label for="name" class="block text-sm font-medium text-gray-900">
                Nombre del Permiso
              </label>
              <div class="mt-2">
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  name="name"
                  autocomplete="permission-name"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  placeholder="Ej: ver usuarios, crear proyectos, eliminar inspecciones"
                  required
                />
                <div v-if="errors.name" class="mt-1 text-sm text-red-600">
                  {{ errors.name }}
                </div>
              </div>
              <p class="mt-2 text-sm text-gray-500">
                Usa nombres descriptivos como "ver usuarios", "crear proyectos", "editar inspecciones".
              </p>
            </div>

            <!-- Guard Name (opcional) -->
            <div class="sm:col-span-2">
              <label for="guard_name" class="block text-sm font-medium text-gray-900">
                Guard Name
              </label>
              <div class="mt-2">
                <input
                  id="guard_name"
                  v-model="form.guard_name"
                  type="text"
                  name="guard_name"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  placeholder="web"
                />
                <div v-if="errors.guard_name" class="mt-1 text-sm text-red-600">
                  {{ errors.guard_name }}
                </div>
              </div>
              <p class="mt-2 text-sm text-gray-500">
                Por defecto es "web". Cambia solo si usas múltiples guards.
              </p>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-8 flex items-center justify-end gap-x-6">
            <Link
              :href="route('permissions.index')"
              class="text-sm font-semibold leading-6 text-gray-900"
            >
              Cancelar
            </Link>
            <button
              type="submit"
              :disabled="processing"
              class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
            >
              <span v-if="processing">Actualizando...</span>
              <span v-else>Actualizar Permiso</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  permission: Object,
  errors: Object,
})

const form = useForm({
  name: props.permission.name,
  guard_name: props.permission.guard_name,
})

const processing = ref(false)

const submitForm = () => {
  processing.value = true
  form.put(route('permissions.update', props.permission.id), {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
