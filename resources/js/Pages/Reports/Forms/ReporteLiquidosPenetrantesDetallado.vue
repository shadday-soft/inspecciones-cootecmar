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

        <!-- Tabla de Tipo de Materiales -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/4">TIPO DE MATERIALES.</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold">FABRICANTE</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold">REF. COMERCIAL</th>
                        <th class="p-2 text-center font-bold">LOTE No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">PENETRANTE:</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_penetrante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_penetrante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_penetrante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">EMULSIFICANTE:</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_emulsificante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_emulsificante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_emulsificante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">LIMPIADOR/REMOVEDOR:</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_limpiador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_limpiador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_limpiador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border-r-2 border-gray-800 p-2 font-bold">REVELADOR:</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_revelador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_revelador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_revelador').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Condiciones de Inspección -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">CONDICIONES DE INSPECCIÓN:</h3>
            
            <!-- PRELIMPIEZA -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">PRELIMPIEZA:</span>
                <div class="flex gap-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="QUÍMICA" v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>QUÍMICA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="MECÁNICA" v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>MECÁNICA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="POR SOLVENTES" v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>POR SOLVENTES</span>
                    </label>
                </div>
            </div>

            <!-- PENETRANTE -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">PENETRANTE:</span>
                <div class="flex gap-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="VISIBLE O COLOREADO" v-model="form.inputs.find(i => i.label === 'penetrante_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>VISIBLE O COLOREADO</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="FLUORESCENTE" v-model="form.inputs.find(i => i.label === 'penetrante_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>FLUORESCENTE</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="DUALES" v-model="form.inputs.find(i => i.label === 'penetrante_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>DUALES</span>
                    </label>
                </div>
            </div>

            <!-- MÉTODO REMOCIÓN DEL PENETRANTE -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">MÉTODO REMOCIÓN DEL PENETRANTE:</span>
                <div class="flex gap-8 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="LAVABLE-AGUA" v-model="form.inputs.find(i => i.label === 'metodo_remocion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>LAVABLE-AGUA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="POST-EMULSIFICABLE" v-model="form.inputs.find(i => i.label === 'metodo_remocion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>POST-EMULSIFICABLE</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="SOLVENTE" v-model="form.inputs.find(i => i.label === 'metodo_remocion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>SOLVENTE</span>
                    </label>
                </div>
            </div>

            <!-- REVELADOR -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">REVELADOR:</span>
                <div class="flex gap-8 flex-wrap">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="POLVO SECO" v-model="form.inputs.find(i => i.label === 'revelador_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>POLVO SECO</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="SUSPENSIÓN NO ACUOSO" v-model="form.inputs.find(i => i.label === 'revelador_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>SUSPENSIÓN NO ACUOSO</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="EN SOLUCIÓN ACUOSA" v-model="form.inputs.find(i => i.label === 'revelador_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>EN SOLUCIÓN ACUOSA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="SUSPENSIÓN ACUOSA" v-model="form.inputs.find(i => i.label === 'revelador_tipo').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>SUSPENSIÓN ACUOSA</span>
                    </label>
                </div>
            </div>

            <!-- ILUMINACIÓN -->
            <div class="flex items-center gap-6">
                <span class="font-bold w-40">ILUMINACIÓN:</span>
                <div class="flex gap-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="VISIBLE" v-model="form.inputs.find(i => i.label === 'iluminacion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>VISIBLE</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="UV" v-model="form.inputs.find(i => i.label === 'iluminacion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>UV</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Tabla de Parámetros de Operación -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">PARÁMETROS DE OPERACIÓN</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">TIEMPO DE PERMANENCIA</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">TEMP. °C DE INSP.</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">MÉTODO APLICACIÓN</th>
                        <th class="p-2 text-center font-bold w-1/5">ILUMINACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="param in parametrosOperacion" :key="param.key" class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">{{ param.label }}</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_tiempo`).value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_temperatura`).value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_metodo`).value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_iluminacion`).value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Discontinuidades -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800">4. CROQUIS (Detalle ver Pág. 2)</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 5%;">ITEM</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 20%;">UBICACIÓN</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 15%;">DESCRIPCIÓN DE LA DISCONTINUIDAD</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 10%;">FORMA<br><small>(LINEAL/REDONDA)</small></th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 15%;">DIMENSIÓN</th>
                        <th class="p-2 text-center font-bold">EVALUACIÓN<br><small>(ACEPTADA/RECHAZADA)</small></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="n in 13" :key="n" class="border-b border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 text-center font-bold">{{ n }}</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="discontinuidades[n-1].ubicacion"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="discontinuidades[n-1].descripcion"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <select v-model="discontinuidades[n-1].forma"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500">
                                <option value="">-</option>
                                <option value="LINEAL">LINEAL</option>
                                <option value="REDONDA">REDONDA</option>
                            </select>
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="discontinuidades[n-1].dimension"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <select v-model="discontinuidades[n-1].evaluacion"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500">
                                <option value="">-</option>
                                <option value="ACEPTADA">ACEPTADA</option>
                                <option value="RECHAZADA">RECHAZADA</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Detalle de la Pieza -->
        <div>
            <label class="font-bold">DETALLE DE LA PIEZA:</label>
            <div class="rounded-lg border border-gray-300 p-4">
                <input 
                    type="file" 
                    @change="handleImageUpload"
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 cursor-pointer"
                />
                <div v-if="detallePiezaImagen" class="mt-4">
                    <p class="text-success font-semibold mb-2">✓ Imagen cargada correctamente</p>
                    <img :src="detallePiezaImagen" alt="Detalle de la pieza" class="border rounded-lg max-w-full h-auto" style="max-height: 400px;" />
                    <button 
                        @click="removeImage" 
                        type="button"
                        class="mt-2 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm"
                    >
                        Eliminar imagen
                    </button>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div>
            <label class="font-bold">OBSERVACIONES:</label>
            <div class="rounded-lg border border-gray-300">
                <QuillEditor theme="snow" v-model:content="form.inputs.find(i => i.label === 'observaciones').value" contentType="html" toolbar="full" />
            </div>
        </div>

        <!-- Resultado Final -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <label class="font-bold block mb-3">RESULTADO FINAL DE LA PRUEBA:</label>
            <div class="flex gap-8">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="SATISFACTORIA" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5" />
                    <span>SATISFACTORIA</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" value="NO SATISFACTORIA" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5" />
                    <span>NO SATISFACTORIA</span>
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
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
    users: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['cancel']);

// Variables reactivas para las firmas
const elaboradoPorNombre = ref('');
const elaboradoPorCargo = ref('');
const elaboradoPorFirma = ref(null);
const revisadoPorNombre = ref('');
const revisadoPorCargo = ref('');
const revisadoPorFirma = ref(null);

// Variable para la imagen del detalle de la pieza
const detallePiezaImagen = ref(null);

// Array para discontinuidades
const discontinuidades = ref(Array.from({ length: 13 }, () => ({
    ubicacion: '',
    descripcion: '',
    forma: '',
    dimension: '',
    evaluacion: ''
})));

// Parámetros de operación
const parametrosOperacion = [
    { key: 'param_secado1', label: 'SECADO' },
    { key: 'param_penetrante', label: 'PENETRANTE' },
    { key: 'param_emulsificador', label: 'EMULSIFICADOR' },
    { key: 'param_enjuague', label: 'ENJUAGUE' },
    { key: 'param_secado2', label: 'SECADO' },
    { key: 'param_revelado', label: 'REVELADO' }
];

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES DETALLADO",
    inputs: [
        { label: "informe_no", type: "text", textLabel: "INFORME No.", value: "" },
        { label: "fecha", type: "date", textLabel: "FECHA", value: "" },
        { label: "go_no", type: "text", textLabel: "G.O No.", value: "" },
        { label: "cliente", type: "text", textLabel: "CLIENTE", value: "" },
        { label: "proyecto", type: "text", textLabel: "PROYECTO", value: "" },
        { label: "sitio_inspeccion", type: "text", textLabel: "SITIO DE INSPECCIÓN", value: "" },
        { label: "ciudad", type: "text", textLabel: "CIUDAD", value: "" },
        { label: "especificacion", type: "text", textLabel: "ESPECIFICACIÓN (NORMA)", value: "" },
        { label: "gerencia", type: "text", textLabel: "GERENCIA", value: "" },
        { label: "pieza_inspeccionar", type: "text", textLabel: "PIEZA A INSPECCIONAR", value: "" },
        { label: "material", type: "text", textLabel: "MATERIAL", value: "" },
        { label: "dimensiones", type: "text", textLabel: "DIMENSIONES", value: "" },
        { label: "area_inspeccionada", type: "text", textLabel: "ÁREA INSPECCIONADA", value: "" },
        { label: "acabado_superficial", type: "text", textLabel: "ACABADO SUPERFICIAL", value: "" },
        { label: "temperatura_pieza", type: "text", textLabel: "TEMPERATURA DE LA PIEZA", value: "" },
        { label: "humedad_relativa", type: "text", textLabel: "HUMEDAD RELATIVA", value: "" },
        { label: "instrumento_medicion", type: "text", textLabel: "INSTRUMENTO DE MEDICIÓN", value: "" },
        { label: "codigo_metrologico", type: "text", textLabel: "CÓDIGO METROLÓGICO", value: "" },
        { label: "fecha_calibracion", type: "date", textLabel: "FECHA DE CALIBRACIÓN", value: "" },
        
        // Materiales
        { label: "fabricante_penetrante", type: "text", textLabel: "FABRICANTE - PENETRANTE", value: "" },
        { label: "ref_comercial_penetrante", type: "text", textLabel: "REF. COMERCIAL - PENETRANTE", value: "" },
        { label: "lote_penetrante", type: "text", textLabel: "LOTE - PENETRANTE", value: "" },
        { label: "fabricante_emulsificante", type: "text", textLabel: "FABRICANTE - EMULSIFICANTE", value: "" },
        { label: "ref_comercial_emulsificante", type: "text", textLabel: "REF. COMERCIAL - EMULSIFICANTE", value: "" },
        { label: "lote_emulsificante", type: "text", textLabel: "LOTE - EMULSIFICANTE", value: "" },
        { label: "fabricante_limpiador", type: "text", textLabel: "FABRICANTE - LIMPIADOR", value: "" },
        { label: "ref_comercial_limpiador", type: "text", textLabel: "REF. COMERCIAL - LIMPIADOR", value: "" },
        { label: "lote_limpiador", type: "text", textLabel: "LOTE - LIMPIADOR", value: "" },
        { label: "fabricante_revelador", type: "text", textLabel: "FABRICANTE - REVELADOR", value: "" },
        { label: "ref_comercial_revelador", type: "text", textLabel: "REF. COMERCIAL - REVELADOR", value: "" },
        { label: "lote_revelador", type: "text", textLabel: "LOTE - REVELADOR", value: "" },
        
        // Condiciones de inspección
        { label: "prelimpieza", type: "multiselect", textLabel: "PRELIMPIEZA", value: [], options: ["QUÍMICA", "MECÁNICA", "POR SOLVENTES"] },
        { label: "penetrante_tipo", type: "multiselect", textLabel: "PENETRANTE TIPO", value: [], options: ["VISIBLE O COLOREADO", "FLUORESCENTE", "DUALES"] },
        { label: "metodo_remocion", type: "multiselect", textLabel: "MÉTODO REMOCIÓN", value: [], options: ["LAVABLE-AGUA", "POST-EMULSIFICABLE", "SOLVENTE"] },
        { label: "revelador_tipo", type: "multiselect", textLabel: "REVELADOR TIPO", value: [], options: ["POLVO SECO", "SUSPENSIÓN NO ACUOSO", "EN SOLUCIÓN ACUOSA", "SUSPENSIÓN ACUOSA"] },
        { label: "iluminacion", type: "multiselect", textLabel: "ILUMINACIÓN", value: [], options: ["VISIBLE", "UV"] },
        
        // Parámetros de operación
        ...parametrosOperacion.flatMap(p => [
            { label: `${p.key}_tiempo`, type: "text", textLabel: `${p.label} - TIEMPO`, value: "" },
            { label: `${p.key}_temperatura`, type: "text", textLabel: `${p.label} - TEMPERATURA`, value: "" },
            { label: `${p.key}_metodo`, type: "text", textLabel: `${p.label} - MÉTODO`, value: "" },
            { label: `${p.key}_iluminacion`, type: "text", textLabel: `${p.label} - ILUMINACIÓN`, value: "" }
        ]),
        
        // Otros campos
        { label: "detalle_pieza", type: "textLong", textLabel: "DETALLE DE LA PIEZA", value: "" },
        { label: "observaciones", type: "textLong", textLabel: "OBSERVACIONES", value: "" },
        { label: "resultado_final", type: "select", textLabel: "RESULTADO FINAL", value: "" }
    ],
});

// Campos principales (excluyendo tablas y secciones especiales)
const mainFields = computed(() => {
    const excludedLabels = [
        'fabricante_penetrante', 'ref_comercial_penetrante', 'lote_penetrante',
        'fabricante_emulsificante', 'ref_comercial_emulsificante', 'lote_emulsificante',
        'fabricante_limpiador', 'ref_comercial_limpiador', 'lote_limpiador',
        'fabricante_revelador', 'ref_comercial_revelador', 'lote_revelador',
        'prelimpieza', 'penetrante_tipo', 'metodo_remocion', 'revelador_tipo', 'iluminacion',
        'detalle_pieza', 'observaciones', 'resultado_final'
    ];
    
    // Excluir también todos los parámetros de operación
    parametrosOperacion.forEach(p => {
        excludedLabels.push(`${p.key}_tiempo`, `${p.key}_temperatura`, `${p.key}_metodo`, `${p.key}_iluminacion`);
    });
    
    return form.inputs.filter(i => i.type !== 'textLong' && !excludedLabels.includes(i.label));
});

function handleImageUpload(event) {
    const file = event.target.files[0];
    if (file) {
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
                text: "La imagen no debe superar los 5MB.",
                icon: "error",
            });
            return;
        }

        // Convertir a base64 para vista previa y almacenamiento
        const reader = new FileReader();
        reader.onload = (e) => {
            detallePiezaImagen.value = e.target.result;
            // Actualizar el valor en el formulario
            const detallePiezaInput = form.inputs.find(i => i.label === 'detalle_pieza');
            if (detallePiezaInput) {
                detallePiezaInput.value = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    detallePiezaImagen.value = null;
    const detallePiezaInput = form.inputs.find(i => i.label === 'detalle_pieza');
    if (detallePiezaInput) {
        detallePiezaInput.value = '';
    }
}

function submit() {
    // Validar campos obligatorios de las firmas
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

    // Agregar discontinuidades como JSON
    form.inputs.push({
        label: "discontinuidades",
        textLabel: "DISCONTINUIDADES",
        value: JSON.stringify(discontinuidades.value)
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
