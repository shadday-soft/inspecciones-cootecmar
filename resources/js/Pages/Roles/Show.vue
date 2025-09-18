<template>
  <AppLayout :title="`Rol: ${role.name}`">
    <div class="p-6">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ role.name }}</h1>
          <p class="text-gray-600 mt-2">Información detallada del rol</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="route('roles.edit', role.id)"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Editar Rol
          </Link>
          <Link
            :href="route('roles.index')"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium"
          >
            Volver
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información del rol -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Rol</h3>
            <dl class="space-y-4">
              <div>
                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ role.name }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Guard Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ role.guard_name }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Creado</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ formatDate(role.created_at) }}
                </dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ formatDate(role.updated_at) }}
                </dd>
              </div>
            </dl>
          </div>
        </div>

        <!-- Permisos asignados -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              Permisos Asignados ({{ role.permissions.length }})
            </h3>
            <div v-if="role.permissions.length > 0" class="space-y-2">
              <span
                v-for="permission in role.permissions"
                :key="permission.id"
                class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full mr-2 mb-2"
              >
                {{ permission.name }}
              </span>
            </div>
            <div v-else class="text-sm text-gray-500">
              Este rol no tiene permisos asignados.
            </div>
          </div>
        </div>
      </div>

      <!-- Usuarios con este rol -->
      <div class="mt-6">
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              Usuarios con este Rol
            </h3>
            <div v-if="roleUsers && roleUsers.length > 0">
              <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                  <thead class="bg-gray-50">
                    <tr>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Usuario
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                      </th>
                      <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Asignado desde
                      </th>
                      <th class="relative px-6 py-3">
                        <span class="sr-only">Acciones</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr v-for="user in roleUsers" :key="user.id">
                      <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                          <img
                            class="h-10 w-10 rounded-full"
                            :src="user.profile_photo_url"
                            :alt="user.name"
                          />
                          <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ user.name }}</div>
                          </div>
                        </div>
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ user.email }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ formatDate(user.pivot?.created_at) }}
                      </td>
                      <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <Link
                          :href="route('users.manage-roles', user.id)"
                          class="text-indigo-600 hover:text-indigo-900"
                        >
                          Gestionar roles
                        </Link>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div v-else class="text-sm text-gray-500">
              No hay usuarios asignados a este rol.
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

defineProps({
  role: Object,
  roleUsers: Array,
})

const formatDate = (dateString) => {
  if (!dateString) return 'N/A'
  return new Date(dateString).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}
</script>
