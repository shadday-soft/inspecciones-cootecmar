<template>
  <AppLayout title="Gestión de Roles">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Roles</h1>
        <Link
          :href="route('roles.create')"
          class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium"
        >
          Crear Rol
        </Link>
      </div>

      <!-- Tabla de roles -->
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <ul class="divide-y divide-gray-200">
          <li v-for="role in roles.data" :key="role.id" class="px-6 py-4">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <h3 class="text-lg font-medium text-gray-900">{{ role.name }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                  {{ role.permissions.length }} permisos asignados
                </p>
                <div class="mt-2">
                  <span
                    v-for="permission in role.permissions.slice(0, 3)"
                    :key="permission.id"
                    class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full mr-2 mb-1"
                  >
                    {{ permission.name }}
                  </span>
                  <span
                    v-if="role.permissions.length > 3"
                    class="text-xs text-gray-500"
                  >
                    y {{ role.permissions.length - 3 }} más...
                  </span>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <Link
                  :href="route('roles.show', role.id)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Ver
                </Link>
                <Link
                  :href="route('roles.edit', role.id)"
                  class="text-green-600 hover:text-green-900 text-sm font-medium"
                >
                  Editar
                </Link>
                <button
                  @click="deleteRole(role)"
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
      <div v-if="roles.links" class="mt-6">
        <nav class="flex justify-center">
          <div class="flex space-x-1">
            <Link
              v-for="link in roles.links"
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
          ¿Estás seguro de que deseas eliminar el rol "{{ roleToDelete?.name }}"? 
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
  roles: Object,
})

const showDeleteModal = ref(false)
const roleToDelete = ref(null)

const deleteRole = (role) => {
  roleToDelete.value = role
  showDeleteModal.value = true
}

const closeDeleteModal = () => {
  showDeleteModal.value = false
  roleToDelete.value = null
}

const confirmDelete = () => {
  if (roleToDelete.value) {
    router.delete(route('roles.destroy', roleToDelete.value.id), {
      onSuccess: () => {
        closeDeleteModal()
      }
    })
  }
}
</script>
