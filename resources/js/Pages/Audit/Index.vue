<template>
  <AppLayout title="Auditoría de Roles y Permisos">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Auditoría de Roles y Permisos</h1>
        <div class="flex space-x-2">
          <button 
            @click="loadStats"
            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium"
          >
            Actualizar
          </button>
        </div>
      </div>

      <!-- Estadísticas -->
      <div v-if="stats" class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-indigo-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ stats.total_audits }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Hoy</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ stats.audits_today }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Esta semana</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ stats.audits_this_week }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
          <div class="p-5">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                  <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                  </svg>
                </div>
              </div>
              <div class="ml-5 w-0 flex-1">
                <dl>
                  <dt class="text-sm font-medium text-gray-500 truncate">Este mes</dt>
                  <dd class="text-lg font-medium text-gray-900">{{ stats.audits_this_month }}</dd>
                </dl>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Filtros y búsqueda -->
      <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
        <div class="px-4 py-6 sm:p-8">
          <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros de búsqueda</h3>
          <form @submit.prevent="search" class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <!-- Búsqueda general -->
            <div>
              <label for="search" class="block text-sm font-medium text-gray-700">
                Buscar
              </label>
              <input
                id="search"
                v-model="searchForm.search"
                type="text"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                placeholder="Buscar en auditoría..."
              />
            </div>

            <!-- Filtro por acción -->
            <div>
              <label for="action" class="block text-sm font-medium text-gray-700">
                Acción
              </label>
              <select
                id="action"
                v-model="searchForm.action"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              >
                <option value="">Todas las acciones</option>
                <option v-for="action in actions" :key="action" :value="action">
                  {{ action }}
                </option>
              </select>
            </div>

            <!-- Filtro por tipo de entidad -->
            <div>
              <label for="entity_type" class="block text-sm font-medium text-gray-700">
                Tipo
              </label>
              <select
                id="entity_type"
                v-model="searchForm.entity_type"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              >
                <option value="">Todos los tipos</option>
                <option v-for="type in entityTypes" :key="type" :value="type">
                  {{ type }}
                </option>
              </select>
            </div>

            <!-- Filtro por usuario -->
            <div>
              <label for="user_id" class="block text-sm font-medium text-gray-700">
                Usuario
              </label>
              <select
                id="user_id"
                v-model="searchForm.user_id"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              >
                <option value="">Todos los usuarios</option>
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.name }}
                </option>
              </select>
            </div>

            <!-- Fecha desde -->
            <div>
              <label for="date_from" class="block text-sm font-medium text-gray-700">
                Desde
              </label>
              <input
                id="date_from"
                v-model="searchForm.date_from"
                type="date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
            </div>

            <!-- Fecha hasta -->
            <div>
              <label for="date_to" class="block text-sm font-medium text-gray-700">
                Hasta
              </label>
              <input
                id="date_to"
                v-model="searchForm.date_to"
                type="date"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
              />
            </div>

            <!-- Botones -->
            <div class="md:col-span-6 flex items-end space-x-2">
              <button
                type="submit"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium"
              >
                Buscar
              </button>
              <button
                type="button"
                @click="clearFilters"
                class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium"
              >
                Limpiar
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Lista de auditorías -->
      <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-6 py-4 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-900">Registros de Auditoría</h3>
          <p class="text-sm text-gray-500 mt-1">
            {{ audits.total }} registros encontrados
          </p>
        </div>
        <ul class="divide-y divide-gray-200">
          <li v-for="audit in audits.data" :key="audit.id" class="px-6 py-4 hover:bg-gray-50">
            <div class="flex items-center justify-between">
              <div class="flex-1">
                <div class="flex items-center space-x-3">
                  <span :class="getActionBadgeClass(audit.action)" class="px-2 py-1 text-xs font-medium rounded-full">
                    {{ audit.action }}
                  </span>
                  <span class="text-sm font-medium text-gray-900">
                    {{ audit.auditable_type }}: {{ getEntityName(audit) }}
                  </span>
                </div>
                <p class="text-sm text-gray-600 mt-1">
                  {{ audit.description }}
                </p>
                <div class="flex items-center space-x-4 mt-2 text-xs text-gray-500">
                  <span>Por: {{ audit.user ? audit.user.name : 'Sistema' }}</span>
                  <span>{{ formatDate(audit.created_at) }}</span>
                </div>
              </div>
              <div class="flex items-center space-x-2">
                <Link
                  :href="route('audit.show', audit.id)"
                  class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                >
                  Ver detalles
                </Link>
              </div>
            </div>
          </li>
        </ul>
      </div>

      <!-- Paginación -->
      <div v-if="audits.links" class="mt-6">
        <nav class="flex justify-center">
          <div class="flex space-x-1">
            <Link
              v-for="link in audits.links"
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
  </AppLayout>
</template>

<script setup>
import { ref, reactive, onMounted } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = defineProps({
  audits: Object,
  filters: Object,
  actions: Array,
  entityTypes: Array,
  users: Array,
})

const stats = ref(null)

// Formulario de búsqueda
const searchForm = reactive({
  search: props.filters?.search || '',
  action: props.filters?.action || '',
  entity_type: props.filters?.entity_type || '',
  user_id: props.filters?.user_id || '',
  date_from: props.filters?.date_from || '',
  date_to: props.filters?.date_to || '',
})

const search = () => {
  router.get(route('audit.index'), searchForm, {
    preserveState: true,
    replace: true,
  })
}

const clearFilters = () => {
  Object.keys(searchForm).forEach(key => {
    searchForm[key] = ''
  })
  router.get(route('audit.index'), {}, {
    preserveState: true,
    replace: true,
  })
}

const loadStats = async () => {
  try {
    const response = await fetch(route('audit.stats'))
    stats.value = await response.json()
  } catch (error) {
    console.error('Error loading stats:', error)
  }
}

const getActionBadgeClass = (action) => {
  const classes = {
    'created': 'bg-green-100 text-green-800',
    'updated': 'bg-blue-100 text-blue-800',
    'deleted': 'bg-red-100 text-red-800',
    'assigned': 'bg-purple-100 text-purple-800',
    'revoked': 'bg-orange-100 text-orange-800',
    'removed': 'bg-orange-100 text-orange-800',
  }
  return classes[action] || 'bg-gray-100 text-gray-800'
}

const getEntityName = (audit) => {
  // Si hay valores nuevos, intentar extraer el nombre
  if (audit.new_values && typeof audit.new_values === 'object') {
    return audit.new_values.name || 'ID: ' + audit.auditable_id
  }
  // Si hay valores antiguos, intentar extraer el nombre
  if (audit.old_values && typeof audit.old_values === 'object') {
    return audit.old_values.name || 'ID: ' + audit.auditable_id
  }
  return 'ID: ' + audit.auditable_id
}

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString('es-ES', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  })
}

onMounted(() => {
  loadStats()
})
</script>
