<template>
    <div class="flex flex-col gap-y-6">
        <!-- Campos del formulario en grid -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <h4 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                <i class="fa-solid fa-list-check text-blue-600 dark:text-blue-400"></i>
                Información del Reporte
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <template v-for="(input, index) of form.inputs.filter(i => i.type !== 'textLong')" :key="index">
                    <CheckboxMultiple
                        v-if="input.type === 'multiselect'"
                        :label="input.textLabel"
                        :options="input.options"
                        v-model="input.value"
                        icon="fa-solid fa-list-check"
                        class="col-span-1 md:col-span-2 lg:col-span-3"
                    />
                    <div v-else>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ input.textLabel }}</label>
                        <div class="rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all">
                        <div v-if="input.type == 'radio'" class="p-3 flex gap-4 flex-wrap">
                            <div v-for="option in input.options" :key="option" class="flex items-center gap-2">
                                <input type="radio" :value="option" v-model="input.value"
                                    :name="input.label"
                                    :id="`${input.label}_${option}`"
                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" />
                                <label :for="`${input.label}_${option}`" class="font-normal">{{ option }}</label>
                            </div>
                        </div>
                    <select v-else-if="input.type == 'select'" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">Seleccione una opción</option>
                        <option v-for="option in input.options" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                    <select v-else-if="input.type == 'userSelect'" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option :value="null">Seleccione un usuario</option>
                        <option v-for="user in users" :key="user.id" :value="user.id">
                            {{ user.name }} {{ user.cargo ? `- ${user.cargo}` : '' }}
                        </option>
                    </select>
                    <input v-else-if="input.type == 'text'" type="text" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200" />
                        <input v-else-if="input.type == 'number'" type="number" v-model="input.value"
                            class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200" />
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- Campos de texto largo -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => i.type === 'textLong')" :key="index"
                 class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4 shadow-sm">
                <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <i class="fa-solid fa-align-left text-blue-600 dark:text-blue-400"></i>
                    {{ input.textLabel }}
                </label>
                <div class="rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
                    <QuillEditor theme="snow" v-model:content="input.value" contentType="html"  :toolbar="['bold', 'italic', 'underline']" />
                </div>
            </div>
        </div>

        <!-- Sección de Firma del Revisor -->
        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-gray-800 dark:to-gray-700 rounded-lg border-2 border-blue-200 dark:border-gray-600 p-6 mt-6">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-blue-300 dark:border-gray-600">
                <div class="bg-blue-600 dark:bg-blue-500 rounded-full p-2">
                    <i class="fa-solid fa-user-check text-white text-xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100">FIRMA DEL REVISOR</h3>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-md">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-id-card text-gray-500 mr-1"></i>
                            Nombre del Revisor:
                        </label>
                        <input type="text" v-model="reviewerName"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Nombre completo" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            <i class="fa-solid fa-briefcase text-gray-500 mr-1"></i>
                            Cargo del Revisor:
                        </label>
                        <input type="text" v-model="reviewerCargo"
                            class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all dark:bg-gray-700 dark:text-gray-200"
                            placeholder="Cargo o posición" />
                    </div>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fa-solid fa-pen-nib text-gray-500"></i>
                        Firma del Revisor:
                    </label>
                    <SignatureCanvas @signature-saved="handleReviewerSignature" />
                    <transition
                        enter-active-class="transition-all duration-300 ease-out"
                        enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100"
                    >
                        <div v-if="reviewerSignature" class="mt-3 p-3 bg-green-50 dark:bg-green-900 border border-green-200 dark:border-green-700 rounded-lg">
                            <p class="text-green-700 dark:text-green-300 font-semibold mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-check"></i>
                                Firma capturada correctamente
                            </p>
                            <img :src="reviewerSignature" alt="Firma del revisor" class="border-2 border-green-300 dark:border-green-600 rounded-lg max-w-full shadow-sm" style="max-height: 100px;" />
                        </div>
                    </transition>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Botones de acción -->
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
        <Button 
            @click="submit" 
            label="Guardar Reporte" 
            severity="success" 
            size="small" 
            icon="fa-solid fa-save"
            :loading="form.processing"
            :disabled="form.processing"
            class="shadow-sm hover:shadow-md transition-shadow"
        />
        <Button 
            label="Cancelar" 
            severity="danger" 
            size="small" 
            icon="fa-solid fa-xmark"
            :disabled="form.processing"
            @click="$emit('cancel')"
            class="shadow-sm hover:shadow-md transition-shadow"
        />
    </div>
</template>

<script setup>
import { useForm, usePage, router } from "@inertiajs/vue3";
import { watch, ref } from "vue";
import SignatureCanvas from "@/Components/Customs/SignatureCanvas.vue";
import CheckboxMultiple from "@/Components/Customs/CheckboxMultiple.vue";
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
    users: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['cancel']);

// Variables reactivas para la firma del revisor
const selectedReviewerUserId = ref(null);
const reviewerName = ref('');
const reviewerCargo = ref('');
const reviewerSignature = ref(null);

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "EVALUACIÓN DE MATERIAL CRÍTICO (HOMOLOGACIÓN)",
    inputs: [
        // I. PARTE DILIGENCIAMIENTO POR PARTE DEL PROVEEDOR
        {
            label: "empresa",
            type: "text",
            textLabel: "EMPRESA",
            value: "",
        },
        {
            label: "producto_homologar",
            type: "text",
            textLabel: "PRODUCTO A HOMOLOGAR",
            value: "",
        },
        {
            label: "tipo_empresa",
            type: "select",
            textLabel: "TIPO DE EMPRESA",
            value: "",
            options: [
                { label: "FABRICANTE DEL PRODUCTO", value: "fabricante" },
                { label: "DISTRIBUIDOR DEL PRODUCTO", value: "distribuidor" }
            ],
        },
        {
            label: "marca_producto",
            type: "text",
            textLabel: "MARCA DEL PRODUCTO",
            value: "",
        },
        {
            label: "norma",
            type: "text",
            textLabel: "NORMA",
            value: "",
        },
        {
            label: "descripcion_general",
            type: "textLong",
            textLabel: "DESCRIPCIÓN GENERAL DEL PRODUCTO",
            value: "",
        },
        {
            label: "propiedades",
            type: "textLong",
            textLabel: "PROPIEDADES",
            value: "",
        },
        {
            label: "objetivos_funciones",
            type: "textLong",
            textLabel: "OBJETIVOS / FUNCIONES DEL PRODUCTO",
            value: "",
        },
        {
            label: "procedimiento_aplicacion",
            type: "textLong",
            textLabel: "PROCEDIMIENTO DE APLICACIÓN (Instrucción de Manejo del material)",
            value: "",
        },
        {
            label: "unidad_venta",
            type: "text",
            textLabel: "DATOS DEL PRODUCTO: Unidad de venta",
            value: "",
        },
        {
            label: "presentacion_producto",
            type: "text",
            textLabel: "Presentación del Producto",
            value: "",
        },
        {
            label: "disponibilidad_presentaciones",
            type: "textLong",
            textLabel: "DISPONIBILIDAD EN OTRAS PRESENTACIONES",
            value: "",
        },
        {
            label: "disponibilidad_material",
            type: "text",
            textLabel: "DISPONIBILIDAD DEL MATERIAL",
            value: "",
        },
       
    ],
});

// Observar cambios en el usuario seleccionado para autocompletar nombre y cargo
watch(selectedReviewerUserId, (userId) => {
    if (userId && props.users.length > 0) {
        const selectedUser = props.users.find(u => u.id === userId);
        if (selectedUser) {
            reviewerName.value = selectedUser.name;
            reviewerCargo.value = selectedUser.cargo || 'Auxiliar de investigación y desarrollo';
        }
    }
});

// Manejar la firma capturada del revisor
function handleReviewerSignature(signatureData) {
    reviewerSignature.value = signatureData;
}

function submit() {
    // Validar que los campos obligatorios del revisor estén completos
    if (!reviewerName.value || !reviewerCargo.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa el nombre y cargo del revisor.",
            icon: "warning",
        });
        return;
    }

    if (!reviewerSignature.value) {
        Swal.fire({
            title: "Firma requerida",
            text: "Por favor captura la firma del revisor antes de guardar.",
            icon: "warning",
        });
        return;
    }

    // Agregar los datos del revisor al formulario antes de enviar
    form.inputs.push(
        {
            label: "reviewed_by_user_id",
            textLabel: "REVISADO Y AUTORIZADO POR (Usuario ID)",
            value: selectedReviewerUserId.value || "",
        },
        {
            label: "reviewed_by_name",
            textLabel: "NOMBRE DEL REVISOR",
            value: reviewerName.value,
        },
        {
            label: "reviewed_by_cargo",
            textLabel: "CARGO DEL REVISOR",
            value: reviewerCargo.value,
        },
        {
            label: "reviewed_by_signature",
            textLabel: "FIRMA DEL REVISOR",
            value: reviewerSignature.value,
        }
    );
    
    form.post(route("reports.store"), {
        onSuccess: () => {
            Swal.fire({
                title: "¡Guardado!",
                text: "El reporte se ha creado correctamente.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
            });
            emit('cancel');
        },
        onError: (errors) => {
            Swal.fire({
                title: "Error",
                text: "No se pudo guardar el reporte. Inténtalo de nuevo.",
                icon: "error",
            });
        },
    });
}
</script>
