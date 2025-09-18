<template>
  <AppLayout :title="`Permiso: ${permission.name}`">
    <div class="p-6">
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">{{ permission.name }}</h1>
          <p class="text-gray-600 mt-2">Información detallada del permiso</p>
        </div>
        <div class="flex space-x-3">
          <Link
            :href="route('permissions.edit', permission.id)"
            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Editar Permiso
          </Link>
          <Link
            :href="route('permissions.index')"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium"
          >
            Volver
          </Link>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Información del permiso -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Permiso</h3>
            <dl class="space-y-4">
              <div>
                <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ permission.name }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Guard Name</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ permission.guard_name }}</dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Creado</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ formatDate(permission.created_at) }}
                </dd>
              </div>
              <div>
                <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                <dd class="mt-1 text-sm text-gray-900">
                  {{ formatDate(permission.updated_at) }}
                </dd>
              </div>
            </dl>
          </div>
        </div>

        <!-- Roles que tienen este permiso -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
          <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">
              Roles con este Permiso
            </h3>
            <div v-if="permissionRoles && permissionRoles.length > 0" class="space-y-2">
              <div
                v-for="role in permissionRoles"
                :key="role.id"
                class="flex items-center justify-between py-2 px-3 bg-gray-50 rounded-md"
              >
                <span class="text-sm font-medium text-gray-900">{{ role.name }}</span>
                <Link
                  :href="route('roles.show', role.id)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm"
                >
                  Ver rol
                </Link>
              </div>
            </div>
            <div v-else class="text-sm text-gray-500">
              Este permiso no está asignado a ningún rol.
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
  permission: Object,
  permissionRoles: Array,
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
