<template>
  <AppLayout :title="`Gestionar Roles de ${user.name}`">
    <div class="p-6">
      <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestionar Roles de {{ user.name }}</h1>
        <p class="text-gray-600 mt-2">Asigna o remueve roles para este usuario.</p>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información del usuario -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Usuario</h3>
            <div class="flex items-center space-x-4 mb-4">
              <img
                class="h-16 w-16 rounded-full"
                :src="user.profile_photo_url"
                :alt="user.name"
              />
              <div>
                <h4 class="text-lg font-medium text-gray-900">{{ user.name }}</h4>
                <p class="text-sm text-gray-500">{{ user.email }}</p>
              </div>
            </div>
            
            <h4 class="text-md font-medium text-gray-900 mb-2">Roles Actuales:</h4>
            <div v-if="user.roles && user.roles.length > 0" class="space-y-2">
              <span
                v-for="role in user.roles"
                :key="role.id"
                class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full mr-2"
              >
                {{ role.name }}
              </span>
            </div>
            <div v-else class="text-sm text-gray-500">
              Este usuario no tiene roles asignados.
            </div>
          </div>
        </div>

        <!-- Formulario para asignar roles -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <form @submit.prevent="submitForm" class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Asignar Roles</h3>
            
            <div class="space-y-3">
              <div
                v-for="role in roles"
                :key="role.id"
                class="relative flex items-start"
              >
                <div class="flex h-6 items-center">
                  <input
                    :id="`role-${role.id}`"
                    v-model="form.roles"
                    :value="role.id"
                    type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600"
                  />
                </div>
                <div class="ml-3 text-sm leading-6">
                  <label
                    :for="`role-${role.id}`"
                    class="font-medium text-gray-900"
                  >
                    {{ role.name }}
                  </label>
                  <p class="text-gray-500 text-xs">
                    {{ role.permissions?.length || 0 }} permisos
                  </p>
                </div>
              </div>
            </div>

            <div v-if="errors.roles" class="mt-2 text-sm text-red-600">
              {{ errors.roles }}
            </div>

            <!-- Botones -->
            <div class="mt-6 flex items-center justify-end gap-x-3">
              <Link
                :href="route('users.index')"
                class="text-sm font-semibold leading-6 text-gray-900"
              >
                Volver a Usuarios
              </Link>
              <button
                type="submit"
                :disabled="processing"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:opacity-50"
              >
                <span v-if="processing">Actualizando...</span>
                <span v-else>Actualizar Roles</span>
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Permisos efectivos del usuario -->
      <div class="mt-6">
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              Permisos Efectivos
            </h3>
            <p class="text-sm text-gray-600 mb-4">
              Estos son todos los permisos que tiene el usuario a través de sus roles asignados.
            </p>
            <div v-if="allPermissions.length > 0" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-2">
              <span
                v-for="permission in allPermissions"
                :key="permission"
                class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full"
              >
                {{ permission }}
              </span>
            </div>
            <div v-else class="text-sm text-gray-500">
              Este usuario no tiene permisos asignados.
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { computed, ref } from 'vue'
import { Link, useForm } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  user: Object,
  roles: Array,
  errors: Object,
})

const form = useForm({
  roles: props.user.roles?.map(role => role.id) || [],
})

const processing = ref(false)

// Calcular todos los permisos únicos del usuario
const allPermissions = computed(() => {
  const permissions = new Set()
  
  props.user.roles?.forEach(role => {
    role.permissions?.forEach(permission => {
      permissions.add(permission.name)
    })
  })
  
  return Array.from(permissions).sort()
})

const submitForm = () => {
  processing.value = true
  form.post(route('users.assign-roles', props.user.id), {
    onFinish: () => {
      processing.value = false
    }
  })
}
</script>
