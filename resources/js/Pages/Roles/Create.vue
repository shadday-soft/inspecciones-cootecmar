<template>
  <AppLayout title="Crear Rol">
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Crear Nuevo Rol</h1>
        <p class="text-gray-600 mt-2">Crea un nuevo rol y asigna permisos específicos.</p>
      </div>

      <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <form @submit.prevent="submitForm" class="px-4 py-6 sm:p-8">
          <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <!-- Nombre del rol -->
            <div class="sm:col-span-4">
              <label for="name" class="block text-sm font-medium text-gray-900">
                Nombre del Rol
              </label>
              <div class="mt-2">
                <input
                  id="name"
                  v-model="form.name"
                  type="text"
                  name="name"
                  autocomplete="role-name"
                  class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                  placeholder="Ej: Editor, Moderador, Analista"
                  required
                />
                <div v-if="errors.name" class="mt-1 text-sm text-red-600">
                  {{ errors.name }}
                </div>
              </div>
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
            </div>

            <!-- Permisos -->
            <div class="col-span-full">
              <label class="block text-sm font-medium text-gray-900">
                Permisos
              </label>
              <p class="text-sm text-gray-600 mt-1">
                Selecciona los permisos que tendrá este rol.
              </p>
              <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <div
                  v-for="permission in permissions"
                  :key="permission.id"
                  class="relative flex items-start"
                >
                  <div class="flex h-6 items-center">
                    <input
                      :id="`permission-${permission.id}`"
                      v-model="form.permissions"
                      :value="permission.id"
                      type="checkbox"
                      class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                    />
                  </div>
                  <div class="ml-3 text-sm leading-6">
                    <label
                      :for="`permission-${permission.id}`"
                      class="font-medium text-gray-900"
                    >
                      {{ permission.name }}
                    </label>
                  </div>
                </div>
              </div>
              <div v-if="errors.permissions" class="mt-1 text-sm text-red-600">
                {{ errors.permissions }}
              </div>
            </div>
          </div>

          <!-- Botones -->
          <div class="mt-8 flex items-center justify-end gap-x-6">
            <Link
              :href="route('roles.index')"
              class="text-sm font-semibold leading-6 text-gray-900"
            >
              Cancelar
            </Link>
            <button
              type="submit"
              :disabled="processing"
              class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
            >
              <span v-if="processing">Creando...</span>
              <span v-else>Crear Rol</span>
            </button>
          </div>
        </form>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  permissions: Array,
  errors: Object,
})

const form = useForm({
  name: '',
  guard_name: 'web',
  permissions: [],
})

const processing = ref(false)

const submitForm = () => {
  processing.value = true
  form.post(route('roles.store'), {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
