<template>
  <AppLayout title="Detalles de Auditoría">
    <div class="p-6">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h1 class="text-2xl font-bold text-gray-900">Detalles de Auditoría</h1>
          <p class="text-sm text-gray-500 mt-1">
            Registro #{{ audit.id }}
          </p>
        </div>
        <Link
          :href="route('audit.index')"
          class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium"
        >
          Volver a la lista
        </Link>
      </div>

      <!-- Información principal -->
      <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Información General
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Detalles del registro de auditoría
          </p>
        </div>
        <div class="border-t border-gray-200">
          <dl>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Acción</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                <span :class="getActionBadgeClass(audit.action)" class="px-2 py-1 text-xs font-medium rounded-full">
                  {{ audit.action }}
                </span>
              </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Tipo de entidad</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ audit.auditable_type }}
              </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">ID de entidad</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ audit.auditable_id || 'N/A' }}
              </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Evento</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ audit.event || 'N/A' }}
              </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Usuario</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ audit.user ? audit.user.name : 'Sistema' }}
                <span v-if="audit.user" class="text-gray-500 ml-2">({{ audit.user.email }})</span>
              </dd>
            </div>
            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Fecha y hora</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ formatDate(audit.created_at) }}
              </dd>
            </div>
            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
              <dt class="text-sm font-medium text-gray-500">Descripción</dt>
              <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                {{ audit.description }}
              </dd>
            </div>
          </dl>
        </div>
      </div>

      <!-- Cambios (si están disponibles) -->
      <div v-if="audit.old_values || audit.new_values" class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Cambios Realizados
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Detalle de los cambios realizados en esta acción
          </p>
        </div>
        <div class="border-t border-gray-200">
          <div class="px-4 py-5 sm:px-6">
            <div v-if="audit.old_values" class="mb-4">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Valores anteriores:</h4>
              <pre class="bg-red-50 p-4 rounded-md text-sm overflow-auto">{{ formatChanges(audit.old_values) }}</pre>
            </div>
            <div v-if="audit.new_values">
              <h4 class="text-sm font-medium text-gray-700 mb-2">Valores nuevos:</h4>
              <pre class="bg-green-50 p-4 rounded-md text-sm overflow-auto">{{ formatChanges(audit.new_values) }}</pre>
            </div>
          </div>
        </div>
      </div>

      <!-- Información adicional del usuario objetivo -->
      <div v-if="audit.target_user_id" class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
          <h3 class="text-lg leading-6 font-medium text-gray-900">
            Usuario Objetivo
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500">
            Usuario afectado por esta acción
          </p>
        </div>
        <div class="border-t border-gray-200">
          <div class="px-4 py-5 sm:px-6">
            <p class="text-sm text-gray-900">
              Usuario ID: {{ audit.target_user_id }}
              <span v-if="audit.target_user" class="ml-2">({{ audit.target_user.name }})</span>
            </p>
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
  audit: Object,
})

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

const formatDate = (dateString) => {
  return new Date(dateString).toLocaleString('es-ES', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
    second: '2-digit'
  })
}

const formatChanges = (changes) => {
  if (typeof changes === 'string') {
    try {
      return JSON.stringify(JSON.parse(changes), null, 2)
    } catch {
      return changes
    }
  }
  return JSON.stringify(changes, null, 2)
}
</script>
