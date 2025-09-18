<template>
  <AppLayout title="Gestión de Permisos">
    <div class="p-6">
      <Datatable
        :data="permissions.data"
        :columnas="columns"
        :actions="tableActions"
        title="Gestión de Permisos"
        :add="{ action: () => router.visit(route('permissions.create')) }"
        emptyMessage="No hay permisos registrados"
      >
        <template #title>
          <div class="flex gap-4 items-center">
            <!-- Filtros -->
            <div class="flex gap-2 items-center">
              <InputText
                v-model="searchForm.search"
                placeholder="Buscar por nombre..."
                @input="search"
                class="w-48"
              />
              <Select
                v-model="searchForm.guard"
                :options="guardOptions"
                optionLabel="label"
                optionValue="value"
                placeholder="Todos los guards"
                @change="search"
                class="w-40"
                showClear
              />
              <Select
                v-model="searchForm.has_roles"
                :options="roleOptions"
                optionLabel="label"
                optionValue="value"
                placeholder="Asignación"
                @change="search"
                class="w-32"
                showClear
              />
              <Button
                @click="clearFilters"
                icon="pi pi-filter-slash"
                severity="secondary"
                outlined
                size="small"
                v-tooltip="'Limpiar filtros'"
              />
            </div>
          </div>
        </template>
      </Datatable>
    </div>

    <!-- Modal de confirmación de eliminación -->
    <ConfirmDialog />
    <Toast />
  </AppLayout>
</template>

<script setup>
import { ref, reactive, computed, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import Datatable from '@/Components/Customs/Datatable.vue'
import { useConfirm } from 'primevue/useconfirm'
import { useToast } from 'primevue/usetoast'

const props = defineProps({
  permissions: Object,
  filters: Object,
  guards: Array,
})

const confirm = useConfirm()
const toast = useToast()

// Formulario de búsqueda
const searchForm = reactive({
  search: props.filters?.search || '',
  guard: props.filters?.guard || '',
  has_roles: props.filters?.has_roles || '',
})

// Opciones para los selects
const guardOptions = computed(() => [
  { label: 'Todos los guards', value: '' },
  ...props.guards.map(guard => ({ label: guard, value: guard }))
])

const roleOptions = [
  { label: 'Todos', value: '' },
  { label: 'Asignados a roles', value: 'yes' },
  { label: 'Sin asignar', value: 'no' }
]

// Configuración de columnas para la tabla
const columns = [
  {
    field: 'name',
    header: 'Nombre del Permiso',
    sortable: true,
    filter: true,
    class: 'font-medium text-gray-900'
  },
  {
    field: 'guard_name',
    header: 'Guard',
    sortable: true,
    filter: true,
    type: 'tag',
    severitys: [
      { text: 'web', severity: 'info', class: 'bg-blue-100 text-blue-800' },
      { text: 'api', severity: 'success', class: 'bg-green-100 text-green-800' },
      { text: 'admin', severity: 'warning', class: 'bg-yellow-100 text-yellow-800' }
    ]
  },
  {
    field: 'roles_count',
    header: 'Roles Asignados',
    class: 'text-center',
    format: (count) => `${count || 0} roles`
  },
  {
    field: 'roles',
    header: 'Vista previa de roles',
    class: 'max-w-xs',
    format: (roles) => {
      if (!roles || roles.length === 0) return 'Sin roles asignados'
      const preview = roles.slice(0, 3).map(r => r.name).join(', ')
      return roles.length > 3 ? `${preview} y ${roles.length - 3} más...` : preview
    }
  },
  {
    field: 'created_at',
    header: 'Fecha de creación',
    type: 'date',
    sortable: true,
    filter: true
  }
]

// Acciones de la tabla
const tableActions = [
  {
    icon: 'pi pi-eye',
    label: 'Ver',
    severity: 'info',
    outlined: true,
    action: (data) => router.visit(route('permissions.show', data.id))
  },
  {
    icon: 'pi pi-pencil',
    label: 'Editar',
    severity: 'warning',
    outlined: true,
    action: (data) => router.visit(route('permissions.edit', data.id))
  },
  {
    icon: 'pi pi-trash',
    label: 'Eliminar',
    severity: 'danger',
    outlined: true,
    action: (data) => deletePermission(data)
  }
]

const search = () => {
  router.get(route('permissions.index'), searchForm, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  searchForm.search = ''
  searchForm.guard = ''
  searchForm.has_roles = ''
  router.get(route('permissions.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleDateString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric'
  })
}

const deletePermission = (permission) => {
  confirm.require({
    message: `¿Estás seguro de que deseas eliminar el permiso "${permission.name}"? Esta acción no se puede deshacer.`,
    header: 'Confirmar eliminación',
    icon: 'pi pi-exclamation-triangle',
    rejectClass: 'p-button-secondary p-button-outlined',
    rejectLabel: 'Cancelar',
    acceptLabel: 'Eliminar',
    accept: () => {
      router.delete(route('permissions.destroy', permission.id), {
        onSuccess: () => {
          toast.add({
            severity: 'success',
            summary: 'Permiso eliminado',
            detail: `El permiso "${permission.name}" ha sido eliminado correctamente`,
            life: 3000
          })
        },
        onError: () => {
          toast.add({
            severity: 'error',
            summary: 'Error',
            detail: 'No se pudo eliminar el permiso',
            life: 3000
          })
        }
      })
    }
  })
}
</script>
