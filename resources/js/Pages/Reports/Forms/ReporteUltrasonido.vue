<template>
    <div class="flex flex-col gap-y-4">
        <!-- Campos principales en grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of mainFields" :key="index">
                <label class="font-bold">{{ input.textLabel }}:</label>
                <div class="rounded-lg border border-gray-300">
                    <input v-if="input.type == 'text'" type="text" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- DATOS COMPONENTE -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800 bg-gray-100">DATOS COMPONENTE (COMPONENT DATA)</h3>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold">ZONA INSPECCIONADA (INSPECTIONED ZONE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'zona_inspeccionada').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">DIMENSIONES (DIMENSIONS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'dimensiones').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ESPECIFICACIÓN DEL MATERIAL (MATERIAL ESPECIFICATION):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'especificacion_material').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ACABADO SUPERFICIAL (SURFACE FINISH):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'acabado_superficial').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ÁREA DE INSPECCIÓN (INSPECTION AREA):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'area_inspeccion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">TEMPERATURA (TEMPERATURE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">PROCESO DE FABRICACIÓN (FABRICATION PROCESS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'proceso_fabricacion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ESPESOR DEL MATERIAL (MATERIAL THICKNESS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'espesor_material').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </div>
        </div>

        <!-- CONDICIONES DE INSPECCIÓN -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800 bg-gray-100">CONDICIONES DE INSPECCIÓN (INSPECTION CONDITION)</h3>
            <div class="p-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-bold">TIPO DE REPRESENTACIÓN (REPRESENTATION TYPE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'tipo_representacion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">MÉTODO DE INSPECCIÓN (INSPECTION METHOD):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'metodo_inspeccion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">TÉCNICA USADA (TECHNIQUE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'tecnica_usada').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ACOPLANTE (COUPLANT):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'acoplante').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">PROCEDIMIENTO (PROCEDURE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'procedimiento').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">BLOQUE DE CALIBRACIÓN (CALIBRATION BLOCK):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'bloque_calibracion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">EQUIPO (EQUIPMENT):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">FRECUENCIA (FREQUENCY):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'frecuencia').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">PALPADOR (UNIT SEARCH):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'palpador').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">MÉTODO DE CALIBRACIÓN (CALIBRATION METHOD):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'metodo_calibracion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">ÁNGULO (ANGLE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'angulo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">CRITERIOS DE ACEPTACIÓN (ACCEPTANCE LEVEL):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'criterios_aceptacion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">CÓDIGO METROLÓGICO (METROLOGICAL CODE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'codigo_metrologico').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-bold">FECHA DE CALIBRACIÓN (CALIBRATION DATE):</label>
                        <input type="date" v-model="form.inputs.find(i => i.label === 'fecha_calibracion').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ESQUEMAS (SKETCHS) -->
        <div>
            <label class="font-bold">ESQUEMAS (SKETCHS):</label>
            <div class="rounded-lg border border-gray-300 p-4">
                <input 
                    type="file" 
                    @change="handleEsquemasUpload"
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer"
                />
                <div v-if="esquemasImagen" class="mt-4">
                    <p class="text-success font-semibold mb-2">✓ Imagen cargada correctamente</p>
                    <img :src="esquemasImagen" alt="Esquemas" class="border rounded-lg max-w-full h-auto" style="max-height: 400px;" />
                    <button 
                        @click="removeEsquemasImage" 
                        type="button"
                        class="mt-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                    >
                        Eliminar imagen
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de Descripción del Defecto -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800 bg-gray-100">DESCRIPCIÓN DEL DEFECTO (FLAW CHARACTERIZATION)</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-200 border-b-2 border-gray-800">
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 5%;">No.<br>ITEM</th>
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 8%;">ÁNGULO<br>INDICACIÓN<br>(ANGLE)</th>
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 8%;">ANCHO CARA<br>DIÁMETRO<br>(FACE WIDTH)<br>mm</th>
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 8%;">PIERNA<br>PIES<br>(FEET LEG)<br>mm</th>
                            <th colspan="4" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 16%;">DECIBELES (INCHES) dB<br>(AWS)</th>
                            <th colspan="3" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 18%;">INDICACIÓN<br>(INVOCATION)</th>
                            <th colspan="2" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 12%;">DISTANCIA<br>(LOCATION)</th>
                            <th class="p-2 text-center font-bold" style="width: 25%;">COMENTARIOS<br>(COMMENTARIES)</th>
                        </tr>
                        <tr class="bg-gray-100 border-b border-gray-800">
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r border-gray-800 p-1 text-center">a</th>
                            <th class="border-r border-gray-800 p-1 text-center">b</th>
                            <th class="border-r border-gray-800 p-1 text-center">c</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">d</th>
                            <th class="border-r border-gray-800 p-1 text-center">PA<br>mm</th>
                            <th class="border-r border-gray-800 p-1 text-center">SA<br>mm</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">DA<br>mm</th>
                            <th class="border-r border-gray-800 p-1 text-center">X<br>(mm)</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">Y</th>
                            <th class="p-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="n in 10" :key="n" class="border-b border-gray-800">
                            <td class="border-r-2 border-gray-800 p-1 text-center font-bold">{{ n }}</td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].angulo_indicacion"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].ancho_cara"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].pierna_pies"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_a"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_b"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_c"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_d"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_pa"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_sa"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_da"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].distancia_x"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].distancia_y"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="p-1">
                                <input type="text" v-model="defectos[n-1].comentarios"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Observaciones -->
        <div>
            <label class="font-bold">OBSERVACIONES (OBSERVATIONS):</label>
            <div class="rounded-lg border border-gray-300">
                <QuillEditor theme="snow" v-model:content="form.inputs.find(i => i.label === 'observaciones').value" contentType="html" toolbar="full" />
            </div>
        </div>

        <!-- Convenciones -->
        <div class="border border-gray-400 rounded-lg p-3 bg-gray-50 text-sm">
            <strong>Convenciones (Conventions):</strong><br>
            <strong>SA:</strong> Distancia De Recorrido Del Sonido (Sweep Distance); <strong>PA:</strong> Longitud Horizontal (Horizontal Position) (RA);<br>
            <strong>DA:</strong> Profundidad (Depth Position);<br>
            <strong>a:</strong> Indication Level; <strong>b:</strong> Reference Level; <strong>c:</strong> Attenuation Factor; <strong>d:</strong> Indication Rating
        </div>

        <!-- Resultado Final -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <label class="font-bold block mb-3">FINAL TEST RESULT:</label>
            <div class="flex gap-8">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="ACEPTADO (ACCEPTED)" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5" />
                    <span>■ ACEPTADO (ACCEPTED)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="RECHAZADO (NON ACCEPTED)" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5" />
                    <span>□ RECHAZADO (NON ACCEPTED)</span>
                </label>
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
import { useForm, usePage, router } from "@inertiajs/vue3";
import { watch, ref, computed } from "vue";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
import Button from "primevue/button";
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
    users: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['cancel']);

// Variables reactivas
const elaboradoPorNombre = ref('');
const elaboradoPorCargo = ref('');
const elaboradoPorFirma = ref(null);
const revisadoPorNombre = ref('');
const revisadoPorCargo = ref('');
const revisadoPorFirma = ref(null);
const esquemasImagen = ref(null);

// Array para defectos (10 filas)
const defectos = ref(Array.from({ length: 10 }, () => ({
    angulo_indicacion: '',
    ancho_cara: '',
    pierna_pies: '',
    decibeles_a: '',
    decibeles_b: '',
    decibeles_c: '',
    decibeles_d: '',
    indicacion_pa: '',
    indicacion_sa: '',
    indicacion_da: '',
    distancia_x: '',
    distancia_y: '',
    comentarios: ''
})));

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR ULTRASONIDO",
    inputs: [
        // Campos principales
        { label: "reporte_no", type: "text", textLabel: "REPORTE (REPORT) No.", value: "" },
        { label: "fecha", type: "date", textLabel: "FECHA (DATE)", value: "" },
        { label: "go_no", type: "text", textLabel: "G.O. No", value: "" },
        { label: "cliente", type: "text", textLabel: "CLIENTE (CUSTOMER)", value: "" },
        { label: "proyecto", type: "text", textLabel: "PROYECTO (PROJECT)", value: "" },
        { label: "lugar_inspeccion", type: "text", textLabel: "LUGAR DE INSPECCIÓN (INSPECTION PLACE)", value: "" },
        { label: "gerencia", type: "text", textLabel: "GERENCIA (MANAGEMENT)", value: "" },
        { label: "especificacion", type: "text", textLabel: "ESPECIFICACIÓN (STANDARD)", value: "" },
        { label: "pieza", type: "text", textLabel: "PIEZA (PIECE)", value: "" },
        
        // Datos Componente
        { label: "zona_inspeccionada", type: "text", textLabel: "ZONA INSPECCIONADA", value: "" },
        { label: "dimensiones", type: "text", textLabel: "DIMENSIONES", value: "" },
        { label: "especificacion_material", type: "text", textLabel: "ESPECIFICACIÓN DEL MATERIAL", value: "" },
        { label: "acabado_superficial", type: "text", textLabel: "ACABADO SUPERFICIAL", value: "" },
        { label: "area_inspeccion", type: "text", textLabel: "ÁREA DE INSPECCIÓN", value: "" },
        { label: "temperatura", type: "text", textLabel: "TEMPERATURA", value: "" },
        { label: "proceso_fabricacion", type: "text", textLabel: "PROCESO DE FABRICACIÓN", value: "" },
        { label: "espesor_material", type: "text", textLabel: "ESPESOR DEL MATERIAL", value: "" },
        
        // Condiciones de Inspección
        { label: "tipo_representacion", type: "text", textLabel: "TIPO DE REPRESENTACIÓN", value: "" },
        { label: "metodo_inspeccion", type: "text", textLabel: "MÉTODO DE INSPECCIÓN", value: "" },
        { label: "tecnica_usada", type: "text", textLabel: "TÉCNICA USADA", value: "" },
        { label: "acoplante", type: "text", textLabel: "ACOPLANTE", value: "" },
        { label: "procedimiento", type: "text", textLabel: "PROCEDIMIENTO", value: "" },
        { label: "bloque_calibracion", type: "text", textLabel: "BLOQUE DE CALIBRACIÓN", value: "" },
        { label: "equipo", type: "text", textLabel: "EQUIPO", value: "" },
        { label: "frecuencia", type: "text", textLabel: "FRECUENCIA", value: "" },
        { label: "palpador", type: "text", textLabel: "PALPADOR", value: "" },
        { label: "metodo_calibracion", type: "text", textLabel: "MÉTODO DE CALIBRACIÓN", value: "" },
        { label: "angulo", type: "text", textLabel: "ÁNGULO", value: "" },
        { label: "criterios_aceptacion", type: "text", textLabel: "CRITERIOS DE ACEPTACIÓN", value: "" },
        { label: "codigo_metrologico", type: "text", textLabel: "CÓDIGO METROLÓGICO", value: "" },
        { label: "fecha_calibracion", type: "date", textLabel: "FECHA DE CALIBRACIÓN", value: "" },
        
        // Otros campos
        { label: "esquemas", type: "textLong", textLabel: "ESQUEMAS", value: "" },
        { label: "observaciones", type: "textLong", textLabel: "OBSERVACIONES", value: "" },
        { label: "resultado_final", type: "select", textLabel: "RESULTADO FINAL", value: "" }
    ],
});

// Campos principales (solo los primeros 9)
const mainFields = computed(() => {
    return form.inputs.filter(i => 
        ['reporte_no', 'fecha', 'go_no', 'cliente', 'proyecto', 'lugar_inspeccion', 'gerencia', 'especificacion', 'pieza'].includes(i.label)
    );
});

function handleEsquemasUpload(event) {
    const file = event.target.files[0];
    if (file) {
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                title: "Archivo inválido",
                text: "Por favor selecciona un archivo de imagen válido.",
                icon: "error",
            });
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                title: "Archivo muy grande",
                text: "La imagen no debe superar los 5MB.",
                icon: "error",
            });
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            esquemasImagen.value = e.target.result;
            const esquemasInput = form.inputs.find(i => i.label === 'esquemas');
            if (esquemasInput) {
                esquemasInput.value = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeEsquemasImage() {
    esquemasImagen.value = null;
    const esquemasInput = form.inputs.find(i => i.label === 'esquemas');
    if (esquemasInput) {
        esquemasInput.value = '';
    }
}

function submit() {
    if (!elaboradoPorNombre.value || !elaboradoPorCargo.value || !elaboradoPorFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa los datos de 'Elaborado Por'.",
            icon: "warning",
        });
        return;
    }

    if (!revisadoPorNombre.value || !revisadoPorCargo.value || !revisadoPorFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa los datos de 'Revisado y Autorizado Por'.",
            icon: "warning",
        });
        return;
    }

    // Agregar defectos como JSON
    form.inputs.push({
        label: "defectos",
        textLabel: "DEFECTOS",
        value: JSON.stringify(defectos.value)
    });

    // Agregar datos de firmas
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
            textLabel: "REVISADO POR - NOMBRE",
            value: revisadoPorNombre.value,
        },
        {
            label: "revisado_por_cargo",
            textLabel: "REVISADO POR - CARGO",
            value: revisadoPorCargo.value,
        },
        {
            label: "revisado_por_firma",
            textLabel: "REVISADO POR - FIRMA",
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
