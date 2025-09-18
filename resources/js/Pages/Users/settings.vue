<template>
    <AppLayout title="Configuraciones del Sistema">
        <Toast />
        <div class="p-6">
            <TabView>
                <!-- Pestaña de Firma -->
                <TabPanel header="Mi Firma">
                    <SignatureTab
                        :user="user"
                        @openUpload="visibleUpload = true"
                        @openDraw="visibleDraw = true"
                        @changeImage="alertChangeImage"
                        @changeDraw="alertChangeDraw"
                    />
                </TabPanel>

                <!-- Pestaña de Usuarios -->
                <TabPanel header="Usuarios">
                    <UsersTab :users="users" />
                </TabPanel>

                <!-- Pestaña de Roles -->
                <TabPanel header="Roles">
                    <RolesTab
                        :roles="roles"
                        :guards="guards"
                        :filters="rolesFilters"
                    />
                </TabPanel>

                <!-- Pestaña de Permisos -->
                <TabPanel header="Permisos">
                    <PermissionsTab
                        :permissions="permissions"
                        :guards="guards"
                        :filters="permissionsFilters"
                    />
                </TabPanel>

                <!-- Pestaña de Auditoría -->
                <TabPanel header="Auditoría">
                    <AuditTab
                        :audits="audits"
                        :actions="actions"
                        :entityTypes="entityTypes"
                        :auditUsers="auditUsers"
                        :filters="auditsFilters"
                        :stats="stats"
                        @loadStats="loadStats"
                        @showDetails="showAuditDetails"
                    />
                </TabPanel>
            </TabView>
        </div>

        <!-- Modales existentes para firma -->
        <Modal v-model="visibleUpload" title="Subir Firma" close-on-escape>
            <div class="card">
                <FileUpload name="signature" @select="handleFile" @before-upload="uploadImage" :multiple="false" :file-limit="1" accept="image/*" :maxFileSize="1000000">
                    <template #empty>
                        <span>Drag and drop files to here to upload.</span>
                    </template>
                </FileUpload>
            </div>
        </Modal>

        <Modal v-model="visibleDraw" title="Dibujar firma" @close="closeDraw" close-on-escape>
            <Signatue  />
        </Modal>

        <!-- Diálogos de confirmación y notificaciones de PrimeVue -->
        <ConfirmDialog />
        <Toast />

        <!-- Modal de detalles de auditoría -->
        <Modal v-model="showAuditDetailModal" title="Detalles de Auditoría" close-on-escape :width="'50rem'">
            <div v-if="selectedAudit" class="space-y-4">
                <div>
                    <h4 class="font-medium text-gray-900">Información General</h4>
                    <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium">Acción:</span>
                            <span :class="getActionBadgeClass(selectedAudit.event)" class="ml-2 inline-block px-2 py-1 text-xs font-medium rounded-full">
                                {{ selectedAudit.event }}
                            </span>
                        </div>
                        <div>
                            <span class="font-medium">Entidad:</span> {{ selectedAudit.auditable_type }}
                        </div>
                        <div>
                            <span class="font-medium">Usuario:</span> {{ selectedAudit.user?.name || 'Sistema' }}
                        </div>
                        <div>
                            <span class="font-medium">Fecha:</span> {{ formatDate(selectedAudit.created_at) }}
                        </div>
                    </div>
                </div>
                
                <div v-if="selectedAudit.old_values" class="border-t pt-4">
                    <h4 class="font-medium text-gray-900">Valores Anteriores</h4>
                    <pre class="mt-2 text-xs bg-gray-100 p-3 rounded overflow-auto">{{ JSON.stringify(selectedAudit.old_values, null, 2) }}</pre>
                </div>
                
                <div v-if="selectedAudit.new_values" class="border-t pt-4">
                    <h4 class="font-medium text-gray-900">Valores Nuevos</h4>
                    <pre class="mt-2 text-xs bg-gray-100 p-3 rounded overflow-auto">{{ JSON.stringify(selectedAudit.new_values, null, 2) }}</pre>
                </div>
            </div>
        </Modal>
    </AppLayout>
</template>

<script setup>
import { ref, reactive, onMounted, computed } from 'vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { useToast } from "primevue/usetoast";
import { useConfirm } from 'primevue/useconfirm';
import AppLayout from '@/Layouts/AppLayout.vue';
import Modal from '@/Components/Customs/Modal.vue';
import Signatue from '@/Components/Customs/Signatue.vue';
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import Toast from 'primevue/toast';
import ConfirmDialog from 'primevue/confirmdialog';
import Swal from 'sweetalert2';

// Componentes de configuración
import SignatureTab from '@/Components/Settings/SignatureTab.vue';
import UsersTab from '@/Components/Settings/UsersTab.vue';
import RolesTab from '@/Components/Settings/RolesTab.vue';
import PermissionsTab from '@/Components/Settings/PermissionsTab.vue';
import AuditTab from '@/Components/Settings/AuditTab.vue';

const toast = useToast();
const confirm = useConfirm();

const props = defineProps({
    user: {
        type: Object,
        required: true,
    },
    users: {
        type: Array,
        default: () => []
    },
    roles: {
        type: Object,
        default: () => ({})
    },
    permissions: {
        type: Object,
        default: () => ({})
    },
    audits: {
        type: Object,
        default: () => ({})
    },
    guards: {
        type: Array,
        default: () => []
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
    rolesFilters: {
        type: Object,
        default: () => ({})
    },
    permissionsFilters: {
        type: Object,
        default: () => ({})
    },
    auditsFilters: {
        type: Object,
        default: () => ({})
    }
});

const user = props.user;
const userSignature = user.signature ? `/storage/${user.signature}` : null;
const stats = ref(null);

// Estados para modales de firma
const visibleDraw = ref(false);
const visibleUpload = ref(false);
const file = ref(null);

// Estados para modales de auditoría
const showAuditDetailModal = ref(false);
const selectedAudit = ref(null);

const form = useForm({
    signature: null
});

// Funciones para firma
const closeDraw = () => {
    visibleDraw.value = false;
};

const handleFile = (event) => {
    file.value = event.files[0];
};

const alertChangeImage = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás a punto de cambiar tu firma, esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar firma!'
    }).then((result) => {
        if (result.isConfirmed) {
            visibleUpload.value = true;
        }
    });
};

const alertChangeDraw = () => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Estás a punto de cambiar tu firma, esta acción no se puede deshacer!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cambiar firma!'
    }).then((result) => {
        if (result.isConfirmed) {
            visibleDraw.value = true;
        }
    });
};

const uploadImage = async () => {
    const formData = new FormData();
    formData.append('signature', file.value);

    router.post(route('users.signature'), formData, {
        onSuccess: () => {
            Swal.fire('Firma actualizada', '', 'success');
            visibleUpload.value = false;
            router.get(route('settings'));
        }
    });
};

// Funciones para auditoría
const loadStats = async () => {
    try {
        const response = await fetch(route('audit.stats'));
        stats.value = await response.json();
    } catch (error) {
        console.error('Error loading stats:', error);
    }
};

const showAuditDetails = (audit) => {
    selectedAudit.value = audit;
    showAuditDetailModal.value = true;
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

onMounted(() => {
    loadStats();
});
</script>