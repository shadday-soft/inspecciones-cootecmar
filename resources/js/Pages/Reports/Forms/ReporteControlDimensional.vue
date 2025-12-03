<template>
    <div class="flex flex-col gap-y-4">
        <!-- Campos principales en grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => !['parte', 'posn', 'temperatura_pieza', 'equipo_medicion_1', 'codigo_metrologico_1', 'equipo_medicion_2', 'codigo_metrologico_2', 'croquis', 'accion_seguir', 'responsable', 'plazo', 'aprobado_para'].includes(i.label))" :key="index">
                <label class="font-bold">{{ input.textLabel }}:</label>
                <div class="rounded-lg border border-gray-300" :class="input.disabled ? 'bg-gray-100' : ''">
                    <input v-if="input.type == 'text'" type="text" v-model="input.value"
                        :disabled="input.disabled"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-75" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        :disabled="input.disabled"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:opacity-75" />
                    <input v-else-if="input.type == 'time'" type="time" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección de Parte, POSN y Temperatura -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">INFORMACIÓN DE LA PIEZA</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">PARTE:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'parte').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">POSN:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'posn').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">TEMPERATURA DE LA PIEZA:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura_pieza').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"
                        placeholder="Ej: 20°C" />
                </div>
            </div>
        </div>

        <!-- Sección de Equipo de Medición -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">EQUIPOS DE MEDICIÓN</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-bold">EQUIPO DE MEDICIÓN 1:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'equipo_medicion_1').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">CÓDIGO METROLÓGICO 1:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'codigo_metrologico_1').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="font-bold">EQUIPO DE MEDICIÓN 2:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'equipo_medicion_2').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">CÓDIGO METROLÓGICO 2:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'codigo_metrologico_2').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección de Croquis -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">CROQUIS / DIAGRAMA</h3>
            <div>
                <label class="font-bold block mb-2">Subir imagen del croquis:</label>
                <input type="file" @change="handleCroquisUpload" accept="image/*"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                <div v-if="croquisPreview" class="mt-4">
                    <p class="text-success font-semibold mb-2">✓ Imagen cargada correctamente</p>
                    <img :src="croquisPreview" alt="Croquis" class="border rounded-lg max-w-md" />
                </div>
            </div>
        </div>

        <!-- Tabla de Dimensiones -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">DIMENSIONES</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border-2 border-gray-400 px-2 py-2 text-center w-16">COTA</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">VALOR TEÓRICO</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">TOLER.</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">VALOR REAL</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">DESVIACIÓN</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">RESULTADO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(dimension, index) in dimensiones" :key="index">
                            <td class="border-2 border-gray-400 px-2 py-2 text-center font-bold">
                                {{ dimension.cota }}
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="dimension.valor_teorico"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="dimension.tolerancia"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="dimension.valor_real"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="dimension.desviacion"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="dimension.resultado"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección de Acciones Correctivas -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">ACCIONES CORRECTIVAS</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">ACCIÓN A SEGUIR:</label>
                    <textarea v-model="form.inputs.find(i => i.label === 'accion_seguir').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" rows="3"></textarea>
                </div>
                <div>
                    <label class="font-bold">RESPONSABLE:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'responsable').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">PLAZO:</label>
                    <input type="date" v-model="form.inputs.find(i => i.label === 'plazo').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección de Aprobado Para -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">APROBADO PARA:</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="PINTURA" v-model="aprobadoPara"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">PINTURA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="CONTINUAR EL PROCESO" v-model="aprobadoPara"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">CONTINUAR EL PROCESO</span>
                    </label>
                </div>
                <div class="flex items-center gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="REPARACIÓN" v-model="aprobadoPara"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">REPARACIÓN</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="ENTREGA FINAL" v-model="aprobadoPara"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">ENTREGA FINAL</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Sección de Firmas -->
        <SignatureSection 
            v-model:elaborado-por-nombre="elaboradoPorNombre"
            v-model:elaborado-por-cargo="elaboradoPorCargo"
            v-model:elaborado-por-firma="elaboradoPorFirma"
            v-model:revisado-por-nombre="revisadoPorNombre"
            v-model:revisado-por-cargo="revisadoPorCargo"
            v-model:revisado-por-firma="revisadoPorFirma"
        />
    </div>

    <div class="flex justify-end gap-x-2 mt-2">
        <Button 
            @click="submit" 
            label="Guardar" 
            severity="success" 
            size="small" 
            icon="fa-solid fa-save"
            :loading="form.processing"
            :disabled="form.processing"
        />
        <Button 
            label="Cancelar" 
            severity="danger" 
            size="small" 
            icon="fa-solid fa-xmark"
            :disabled="form.processing"
            @click="$emit('cancel')"
        />
    </div>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
});

const emit = defineEmits(['cancel']);

// Variables reactivas para las firmas
const elaboradoPorNombre = ref('');
const elaboradoPorCargo = ref('');
const elaboradoPorFirma = ref(null);
const revisadoPorNombre = ref('');
const revisadoPorCargo = ref('');
const revisadoPorFirma = ref(null);

// Variables para croquis
const croquisPreview = ref(null);

// Variables para aprobado para (multiselect)
const aprobadoPara = ref([]);

// Array de dimensiones (cotas A-N = 14 filas)
const dimensiones = ref([
    { cota: 'A', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'B', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'C', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'D', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'E', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'F', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'G', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'H', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'I', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'J', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'K', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'L', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'M', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
    { cota: 'N', valor_teorico: '', tolerancia: '', valor_real: '', desviacion: '', resultado: '' },
]);

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "CONTROL DIMENSIONAL",
    inputs: [
        {
            label: "gerencia",
            type: "text",
            textLabel: "GERENCIA",
            value: props.inspeccion.gerencia || "",
            disabled: true,
        },
        {
            label: "proyecto",
            type: "text",
            textLabel: "PROYECTO",
            value: props.inspeccion.project?.name || "",
            disabled: true,
        },
        {
            label: "descripcion",
            type: "text",
            textLabel: "DESCRIPCIÓN",
            value: "",
        },
        {
            label: "plano",
            type: "text",
            textLabel: "PLANO",
            value: "",
        },
        {
            label: "subproceso",
            type: "text",
            textLabel: "SUBPROCESO",
            value: "",
        },
        {
            label: "fecha",
            type: "date",
            textLabel: "FECHA",
            value: props.inspeccion.fecha || "",
            disabled: true,
        },
        {
            label: "hora",
            type: "time",
            textLabel: "HORA",
            value: "",
        },
        {
            label: "registro_no",
            type: "text",
            textLabel: "REGISTRO No.",
            value: props.inspeccion.code || "",
            disabled: true,
        },
        {
            label: "parte",
            type: "text",
            textLabel: "PARTE",
            value: "",
        },
        {
            label: "posn",
            type: "text",
            textLabel: "POSN",
            value: "",
        },
        {
            label: "temperatura_pieza",
            type: "text",
            textLabel: "TEMPERATURA DE LA PIEZA",
            value: "",
        },
        {
            label: "equipo_medicion_1",
            type: "text",
            textLabel: "EQUIPO DE MEDICIÓN 1",
            value: "",
        },
        {
            label: "codigo_metrologico_1",
            type: "text",
            textLabel: "CÓDIGO METROLÓGICO 1",
            value: "",
        },
        {
            label: "equipo_medicion_2",
            type: "text",
            textLabel: "EQUIPO DE MEDICIÓN 2",
            value: "",
        },
        {
            label: "codigo_metrologico_2",
            type: "text",
            textLabel: "CÓDIGO METROLÓGICO 2",
            value: "",
        },
        {
            label: "croquis",
            type: "image",
            textLabel: "CROQUIS",
            value: "",
        },
        {
            label: "accion_seguir",
            type: "text",
            textLabel: "ACCIÓN A SEGUIR",
            value: "",
        },
        {
            label: "responsable",
            type: "text",
            textLabel: "RESPONSABLE",
            value: "",
        },
        {
            label: "plazo",
            type: "date",
            textLabel: "PLAZO",
            value: "",
        },
        {
            label: "aprobado_para",
            type: "multiselect",
            textLabel: "APROBADO PARA",
            value: [],
        },
    ],
});

// Manejar carga de imagen del croquis
function handleCroquisUpload(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Validar que sea una imagen
    if (!file.type.startsWith('image/')) {
        Swal.fire({
            title: "Archivo inválido",
            text: "Por favor selecciona un archivo de imagen válido.",
            icon: "error",
        });
        return;
    }

    // Validar tamaño (máximo 5MB)
    if (file.size > 5 * 1024 * 1024) {
        Swal.fire({
            title: "Archivo muy grande",
            text: "El tamaño máximo permitido es 5MB.",
            icon: "error",
        });
        return;
    }

    // Convertir a base64
    const reader = new FileReader();
    reader.onload = (e) => {
        croquisPreview.value = e.target.result;
        form.inputs.find(i => i.label === 'croquis').value = e.target.result;
    };
    reader.readAsDataURL(file);
}

function submit() {
    // Validar que todos los campos de firma estén completos
    if (!elaboradoPorNombre.value || !elaboradoPorCargo.value || !elaboradoPorFirma.value ||
        !revisadoPorNombre.value || !revisadoPorCargo.value || !revisadoPorFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa todos los campos de las firmas antes de guardar.",
            icon: "warning",
        });
        return;
    }

    // Agregar dimensiones al formulario
    dimensiones.value.forEach((dim, index) => {
        form.inputs.push({
            label: `dimension_${dim.cota.toLowerCase()}_valor_teorico`,
            textLabel: `DIMENSIÓN ${dim.cota} - VALOR TEÓRICO`,
            value: dim.valor_teorico,
        });
        form.inputs.push({
            label: `dimension_${dim.cota.toLowerCase()}_tolerancia`,
            textLabel: `DIMENSIÓN ${dim.cota} - TOLERANCIA`,
            value: dim.tolerancia,
        });
        form.inputs.push({
            label: `dimension_${dim.cota.toLowerCase()}_valor_real`,
            textLabel: `DIMENSIÓN ${dim.cota} - VALOR REAL`,
            value: dim.valor_real,
        });
        form.inputs.push({
            label: `dimension_${dim.cota.toLowerCase()}_desviacion`,
            textLabel: `DIMENSIÓN ${dim.cota} - DESVIACIÓN`,
            value: dim.desviacion,
        });
        form.inputs.push({
            label: `dimension_${dim.cota.toLowerCase()}_resultado`,
            textLabel: `DIMENSIÓN ${dim.cota} - RESULTADO`,
            value: dim.resultado,
        });
    });

    // Agregar aprobado para
    form.inputs.find(i => i.label === 'aprobado_para').value = aprobadoPara.value;

    // Agregar los datos de las firmas al formulario antes de enviar
    form.inputs.push(
        {
            label: "elaborado_por_nombre",
            textLabel: "ELABORADO POR - NOMBRE",
            value: elaboradoPorNombre.value,
        },
        {
            label: "elaborado_por_cargo",
            textLabel: "ELABORADO POR - CARGO",
            value: elaboradoPorCargo.value,
        },
        {
            label: "elaborado_por_firma",
            textLabel: "ELABORADO POR - FIRMA",
            value: elaboradoPorFirma.value,
        },
        {
            label: "revisado_por_nombre",
            textLabel: "REVISADO Y AUTORIZADO POR - NOMBRE",
            value: revisadoPorNombre.value,
        },
        {
            label: "revisado_por_cargo",
            textLabel: "REVISADO Y AUTORIZADO POR - CARGO",
            value: revisadoPorCargo.value,
        },
        {
            label: "revisado_por_firma",
            textLabel: "REVISADO Y AUTORIZADO POR - FIRMA",
            value: revisadoPorFirma.value,
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
