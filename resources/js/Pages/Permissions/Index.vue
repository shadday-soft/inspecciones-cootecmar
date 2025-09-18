<template>
  <AppLayout title="Gestión de Permisos">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Permisos</h1>
        <Link
          :href="route('permissions.create')"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
        >
          Crear Permiso
        </Link>
      </div>

      <!-- Tabla de permisos -->
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Lista de Permisos</h3>
          <p class="text-sm text-gray-500 mt-1">
            Total: {{ permissions.data.length }} permisos
          </p>
        </div>
        <ul class="divide-y divide-gray-200">
          <li v-for="permission in permissions.data" :key="permission.id" class="px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-900">{{ permission.name }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                  Guard: {{ permission.guard_name }}
                </p>
                <p class="text-xs text-gray-400 mt-1">
                  Creado: {{ formatDate(permission.created_at) }}
                </p>
              </div>
              <div class="flex items-center space-x-2">
                <Link
                  :href="route('permissions.show', permission.id)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Ver
                </Link>
                <Link
                  :href="route('permissions.edit', permission.id)"
                  class="text-green-600 hover:text-green-900 text-sm font-medium"
                >
                  Editar
                </Link>
                <button
                  @click="deletePermission(permission)"
                  class="text-red-600 hover:text-red-900 text-sm font-medium"
                >
                  Eliminar
                </button>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Paginación -->
      <div v-if="permissions.links" class="mt-6">
        <nav class="flex justify-center">
          <div class="flex space-x-1">
            <Link
              v-for="link in permissions.links"
              :key="link.label"
              :href="link.url"
              :class="[
                'px-3 py-2 text-sm rounded-md',
                link.active
                  ? 'bg-blue-600 text-white'
                  : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300'
              ]"
              v-html="link.label"
            />
          </div>
        </nav>
      </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <Modal :show="showDeleteModal" @close="closeDeleteModal">
      <div class="p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Confirmar eliminación</h3>
        <p class="text-sm text-gray-700 mb-6">
          ¿Estás seguro de que deseas eliminar el permiso "{{ permissionToDelete?.name }}"? 
          Esta acción no se puede deshacer.
        </p>
        <div class="flex justify-end space-x-3">
          <button
            @click="closeDeleteModal"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium"
          >
            Cancelar
          </button>
          <button
            @click="confirmDelete"
            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Eliminar
          </button>
        </div>
      </div>
    </Modal>
  </AppLayout>
</template>

<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Modal from '@/Components/Customs/Modal.vue'

defineProps({
  permissions: Object,
})

const showDeleteModal = ref(false)
const permissionToDelete = ref(null)

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const deletePermission = (permission) => {
  permissionToDelete.value = permission
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  permissionToDelete.value = null
}

const confirmDelete = () => {
  if (permissionToDelete.value) {
    router.delete(route('permissions.destroy', permissionToDelete.value.id), {
      onSuccess: () => {
        closeDeleteModal()
      }
    })
  }
}
</script>
