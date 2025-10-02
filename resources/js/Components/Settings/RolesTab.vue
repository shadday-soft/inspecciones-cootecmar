<template>
    <div class="p-1">
        <Datatable
            :data="roles?.data || []"
            :columnas="columns"
            :actions="tableActions"
            title="Gestión de Roles"
            :add="{ action: () => router.visit(route('roles.create')) }"
            emptyMessage="No hay roles registrados"
        >
           
        </Datatable>
    </div>

    <!-- Diálogos de confirmación y notificaciones -->
    <ConfirmDialog />
    <Toast />
</template>

<script setup>
import { reactive, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import Datatable from '@/Components/Customs/Datatable.vue';
import { useConfirm } from 'primevue/useconfirm';
import { useToast } from 'primevue/usetoast';

const props = defineProps({
    roles: {
        type: Object,
        default: () => ({})
    },
    guards: {
        type: Array,
        default: () => []
    },
    filters: {
        type: Object,
        default: () => ({})
    }
});

const confirm = useConfirm();
const toast = useToast();

// Formulario de búsqueda
const searchForm = reactive({
    search: props.filters?.search || '',
    guard: props.filters?.guard || '',
    has_permissions: props.filters?.has_permissions || '',
});

// Opciones para los selects
const guardOptions = computed(() => [
    { label: 'Todos los guards', value: '' },
    ...props.guards.map(guard => ({ label: guard, value: guard }))
]);

const permissionOptions = [
    { label: 'Todos', value: '' },
    { label: 'Con permisos', value: 'yes' },
    { label: 'Sin permisos', value: 'no' }
];

// Configuración de columnas para la tabla
const columns = [
    {
        field: 'name',
        header: 'Nombre del Rol',
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
        field: 'permissions',
        header: 'Permisos',
        class: 'text-center',
        format: (permissions) => `${permissions?.length || 0} permisos`
    },
    
    {
        field: 'created_at',
        header: 'Fecha de creación',
        type: 'date',
        sortable: true,
        filter: true
    }
];

// Acciones de la tabla
const tableActions = [
    {
        icon: 'pi pi-eye',
        label: 'Ver',
        severity: 'info',
        outlined: true,
        action: (data) => router.visit(route('roles.show', data.id))
    },
    {
        icon: 'pi pi-pencil',
        label: 'Editar',
        severity: 'warning',
        outlined: true,
        action: (data) => router.visit(route('roles.edit', data.id))
    },
    {
        icon: 'pi pi-trash',
        label: 'Eliminar',
        severity: 'danger',
        outlined: true,
        action: (data) => deleteRole(data)
    }
];

const search = () => {
    router.get(route('settings'), {
        tab: 'roles',
        ...searchForm
    }, {
        preserveState: true,
        replace: true,
    });
};

const clearFilters = () => {
    searchForm.search = '';
    searchForm.guard = '';
    searchForm.has_permissions = '';
    router.get(route('settings'), { tab: 'roles' }, {
        preserveState: true,
        replace: true,
    });
};

const deleteRole = (role) => {
    confirm.require({
        message: `¿Estás seguro de que deseas eliminar el rol "${role.name}"? Esta acción no se puede deshacer.`,
        header: 'Confirmar eliminación',
        icon: 'pi pi-exclamation-triangle',
        rejectClass: 'p-button-secondary p-button-outlined',
        rejectLabel: 'Cancelar',
        acceptLabel: 'Eliminar',
        accept: () => {
            router.delete(route('roles.destroy', role.id), {
                onSuccess: () => {
                    toast.add({
                        severity: 'success',
                        summary: 'Rol eliminado',
                        detail: `El rol "${role.name}" ha sido eliminado correctamente`,
                        life: 3000
                    });
                    router.get(route('settings'), { tab: 'roles' });
                },
                onError: () => {
                    toast.add({
                        severity: 'error',
                        summary: 'Error',
                        detail: 'No se pudo eliminar el rol',
                        life: 3000
                    });
                }
            });
        }
    });
};
</script>
