<template>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-900">Auditoría de Roles y Permisos</h2>
        <div class="flex space-x-2">
            <button 
                @click="$emit('loadStats')"
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
                            <i class="fa-solid fa-users text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Usuarios</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ stats.total_users || 0 }}</dd>
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
                            <i class="fa-solid fa-shield text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Roles</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ stats.total_roles || 0 }}</dd>
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
                            <i class="fa-solid fa-key text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Permisos</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ stats.total_permissions || 0 }}</dd>
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
                            <i class="fa-solid fa-clock text-white"></i>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Registros Hoy</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ stats.today_records || 0 }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtros y búsqueda para auditoría -->
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl mb-6">
        <div class="px-4 py-6 sm:p-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Filtros de búsqueda</h3>
            <form @submit.prevent="search" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <!-- Búsqueda general -->
                <div>
                    <label for="search_audits" class="block text-sm font-medium text-gray-700">
                        Buscar
                    </label>
                    <input
                        id="search_audits"
                        v-model="searchForm.search"
                        type="text"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                        placeholder="Buscar en auditoría..."
                    />
                </div>

                <!-- Filtro por acción -->
                <div>
                    <label for="action_audits" class="block text-sm font-medium text-gray-700">
                        Acción
                    </label>
                    <select
                        id="action_audits"
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
                    <label for="entity_type_audits" class="block text-sm font-medium text-gray-700">
                        Tipo de Entidad
                    </label>
                    <select
                        id="entity_type_audits"
                        v-model="searchForm.entity_type"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Todos los tipos</option>
                        <option v-for="entityType in entityTypes" :key="entityType" :value="entityType">
                            {{ entityType }}
                        </option>
                    </select>
                </div>

                <!-- Filtro por usuario -->
                <div>
                    <label for="user_id_audits" class="block text-sm font-medium text-gray-700">
                        Usuario
                    </label>
                    <select
                        id="user_id_audits"
                        v-model="searchForm.user_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">Todos los usuarios</option>
                        <option v-for="auditUser in auditUsers" :key="auditUser.id" :value="auditUser.id">
                            {{ auditUser.name }}
                        </option>
                    </select>
                </div>

                <!-- Fecha desde -->
                <div>
                    <label for="date_from_audits" class="block text-sm font-medium text-gray-700">
                        Fecha Desde
                    </label>
                    <input
                        id="date_from_audits"
                        v-model="searchForm.date_from"
                        type="date"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    />
                </div>

                <!-- Fecha hasta -->
                <div>
                    <label for="date_to_audits" class="block text-sm font-medium text-gray-700">
                        Fecha Hasta
                    </label>
                    <input
                        id="date_to_audits"
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
                {{ audits?.total || 0 }} registros encontrados
            </p>
        </div>
        <ul class="divide-y divide-gray-200" v-if="audits?.data">
            <li v-for="audit in audits.data" :key="audit.id" class="px-6 py-4 hover:bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3">
                            <span
                                :class="getActionBadgeClass(audit.event)"
                                class="inline-block px-2 py-1 text-xs font-medium rounded-full"
                            >
                                {{ audit.event }}
                            </span>
                            <span class="text-sm font-medium text-gray-900">
                                {{ audit.auditable_type }}
                            </span>
                            <span class="text-sm text-gray-500">
                                {{ getEntityName(audit) }}
                            </span>
                        </div>
                        <div class="mt-1 flex items-center space-x-4">
                            <span class="text-sm text-gray-600">
                                Usuario: {{ audit.user?.name || 'Sistema' }}
                            </span>
                            <span class="text-xs text-gray-400">
                                {{ formatDate(audit.created_at) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button
                            @click="$emit('showDetails', audit)"
                            class="text-indigo-600 hover:text-indigo-900 text-sm font-medium"
                        >
                            Ver Detalles
                        </button>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    <!-- Paginación de auditorías -->
    <div v-if="audits?.links" class="mt-6">
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
</template>

<script setup>
import { reactive } from 'vue';
import { Link, router } from '@inertiajs/vue3';

const props = defineProps({
    audits: {
        type: Object,
        default: () => ({})
    },
    actions: {
        type: Array,
        default: () => []
    },
    entityTypes: {
        type: Array,
        default: () => []
    },
    auditUsers: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    },
    stats: {
        type: Object,
        default: null
    }
});

const emit = defineEmits(['loadStats', 'showDetails']);

// Formulario de búsqueda
const searchForm = reactive({
    search: props.filters?.search || '',
    action: props.filters?.action || '',
    entity_type: props.filters?.entity_type || '',
    user_id: props.filters?.user_id || '',
    date_from: props.filters?.date_from || '',
    date_to: props.filters?.date_to || '',
});

const search = () => {
    router.get(route('settings'), {
        tab: 'audit',
        ...searchForm
    }, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    Object.keys(searchForm).forEach(key => {
        searchForm[key] = '';
    });
    router.get(route('settings'), { tab: 'audit' }, {
        preserveState: true,
        replace: true,
    });
};

const getActionBadgeClass = (action) => {
    const classes = {
        'created': 'bg-green-100 text-green-800',
        'updated': 'bg-blue-100 text-blue-800',
        'deleted': 'bg-red-100 text-red-800',
        'assigned': 'bg-purple-100 text-purple-800',
        'revoked': 'bg-orange-100 text-orange-800',
        'removed': 'bg-orange-100 text-orange-800',
    };
    return classes[action] || 'bg-gray-100 text-gray-800';
};

const getEntityName = (audit) => {
    // Si hay valores nuevos, intentar extraer el nombre
    if (audit.new_values && typeof audit.new_values === 'object') {
        return audit.new_values.name || 'ID: ' + audit.auditable_id;
    }
    // Si hay valores antiguos, intentar extraer el nombre
    if (audit.old_values && typeof audit.old_values === 'object') {
        return audit.old_values.name || 'ID: ' + audit.auditable_id;
    }
    return 'ID: ' + audit.auditable_id;
};

const formatDate = (dateString) => {
    return new Date(dateString).toLocaleString('es-ES', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};
</script>
