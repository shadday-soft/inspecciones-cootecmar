<template>
    <div class="flex flex-col gap-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => i.type !== 'textLong' && !['prelimpieza', 'penetrante', 'penetrante_otro', 'revelador', 'revelador_otro', 'iluminacion', 'parametros_secado_tiempo', 'parametros_secado_temperatura', 'parametros_secado_metodo_aplicacion', 'parametros_secado_iluminacion', 'parametros_penetracion_tiempo', 'parametros_penetracion_temperatura', 'parametros_penetracion_metodo_aplicacion', 'parametros_penetracion_iluminacion', 'parametros_revelado_tiempo', 'parametros_revelado_temperatura', 'parametros_revelado_metodo_aplicacion', 'parametros_revelado_iluminacion', 'fabricante_limpiador', 'ref_comercial_limpiador', 'lote_limpiador', 'fabricante_penetracion', 'ref_comercial_penetracion', 'lote_penetracion', 'fabricante_revelado', 'ref_comercial_revelado', 'lote_revelado'].includes(i.label))" :key="index"
                :class="input.type === 'multiselect' ? 'col-span-1 md:col-span-3' : ''">
                <label class="font-bold">{{ input.textLabel }}:</label>
                <div class="rounded-lg border border-gray-300">
                    <div v-if="input.type == 'multiselect'" class="p-3 flex gap-4 flex-wrap">
                        <div v-for="option in input.options" :key="option" class="flex items-center gap-2">
                            <input type="checkbox" :value="option" v-model="input.value"
                                :id="`${input.label}_${option}`"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
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
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección especial de Condiciones de Inspección -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">CONDICIONES DE INSPECCIÓN:</h3>
            
            <!-- PRELIMPIEZA -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">PRELIMPIEZA:</span>
                <div class="flex gap-8">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="QUIMICA" v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>QUÍMICA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="MECANICA" v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>MECANICA</span>
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
                <div class="flex gap-8 flex-wrap items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="ACPM" v-model="form.inputs.find(i => i.label === 'penetrante').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>ACPM</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="LÍQUIDO PENETRANTE (COLOREADO)" v-model="form.inputs.find(i => i.label === 'penetrante').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>LÍQUIDO PENETRANTE (COLOREADO)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="OTRO" v-model="form.inputs.find(i => i.label === 'penetrante').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>OTRO:</span>
                    </label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'penetrante_otro').value"
                        class="border-b-2 border-gray-400 px-2 py-1 w-48 focus:outline-none focus:border-blue-500"
                        placeholder="especificar" />
                </div>
            </div>

            <!-- REVELADOR -->
            <div class="flex items-center gap-6 mb-3 border-b pb-3">
                <span class="font-bold w-40">REVELADOR:</span>
                <div class="flex gap-8 flex-wrap items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="CAL" v-model="form.inputs.find(i => i.label === 'revelador').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>CAL</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="EN SOLUCION NO ACUOSA" v-model="form.inputs.find(i => i.label === 'revelador').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>EN SOLUCIÓN NO ACUOSA</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" value="OTRO" v-model="form.inputs.find(i => i.label === 'revelador').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>OTRO:</span>
                    </label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'revelador_otro').value"
                        class="border-b-2 border-gray-400 px-2 py-1 w-48 focus:outline-none focus:border-blue-500"
                        placeholder="especificar" />
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
                        <input type="checkbox" value="LIMITADA" v-model="form.inputs.find(i => i.label === 'iluminacion').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span>LIMITADA</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Tabla de Parámetros de Operación -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">PARÁMETROS DE<br>OPERACIÓN.</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">TIEMPO DE<br>PERMANENCIA</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">TEMP. °C<br>(PIEZA)</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">MÉTODO<br>APLICACIÓN</th>
                        <th class="p-2 text-center font-bold w-1/5">ILUMINACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">SECADO</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_tiempo').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_temperatura').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_metodo_aplicacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_iluminacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">PENETRACIÓN</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_tiempo').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_temperatura').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_metodo_aplicacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_iluminacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border-r-2 border-gray-800 p-2 font-bold">REVELADO</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_tiempo').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_temperatura').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_metodo_aplicacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_iluminacion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Fabricantes -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 w-1/4"></th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold">FABRICANTE</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold">REF. COMERCIAL</th>
                        <th class="p-2 text-center font-bold">LOTE No.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">LIMPIADOR</td>
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
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">PENETRACIÓN</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_penetracion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_penetracion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_penetracion').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border-r-2 border-gray-800 p-2 font-bold">REVELADO</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_revelado').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_revelado').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_revelado').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-for="(input, index) of form.inputs.filter(i => i.type === 'textLong')" :key="index">
            <label class="font-bold">{{ input.textLabel }}:</label>
            <div class="rounded-lg border border-gray-300">
                <QuillEditor theme="snow" v-model:content="input.value" contentType="html" toolbar="full" />
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
import { watch, ref } from "vue";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
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

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES",
    inputs: [
        {
            label: "informe_no",
            type: "text",
            textLabel: "INFORME No.",
            value: "",
        },
        {
            label: "fecha",
            type: "date",
            textLabel: "FECHA",
            value: "",
        },
        {
            label: "cliente",
            type: "text",
            textLabel: "CLIENTE",
            value: "",
        },
        {
            label: "proyecto",
            type: "text",
            textLabel: "PROYECTO",
            value: "",
        },
        {
            label: "sitio_inspeccion",
            type: "text",
            textLabel: "SITIO DE INSPECCIÓN",
            value: "",
        },
        {
            label: "ciudad",
            type: "text",
            textLabel: "CIUDAD",
            value: "",
        },
        {
            label: "especificacion",
            type: "text",
            textLabel: "ESPECIFICACIÓN",
            value: "",
        },
        {
            label: "gerencia",
            type: "text",
            textLabel: "GERENCIA",
            value: "",
        },
        {
            label: "pieza_inspeccionada",
            type: "text",
            textLabel: "PIEZA INSPECCIONADA",
            value: "",
        },
        {
            label: "material",
            type: "text",
            textLabel: "MATERIAL",
            value: "",
        },
        {
            label: "dimensiones",
            type: "text",
            textLabel: "DIMENSIONES",
            value: "",
        },
        {
            label: "acabado_superficial",
            type: "text",
            textLabel: "ACABADO SUPERFICIAL",
            value: "",
        },
        {
            label: "instrumento_medicion",
            type: "text",
            textLabel: "INSTRUMENTO DE MEDICIÓN",
            value: "",
        },
        {
            label: "codigo_metrologico",
            type: "text",
            textLabel: "CÓDIGO METROLÓGICO",
            value: "",
        },
        {
            label: "fecha_calibracion",
            type: "date",
            textLabel: "FECHA DE CALIBRACIÓN",
            value: "",
        },
        {
            label: "prelimpieza",
            type: "multiselect",
            textLabel: "CONDICIONES DE INSPECCIÓN - PRELIMPIEZA",
            value: [],
            options: ["QUIMICA", "MECANICA", "POR SOLVENTES"],
        },
        {
            label: "penetrante",
            type: "multiselect",
            textLabel: "PENETRANTE",
            value: [],
            options: ["ACPM", "LÍQUIDO PENETRANTE (COLOREADO)", "OTRO"],
        },
        {
            label: "penetrante_otro",
            type: "text",
            textLabel: "PENETRANTE - OTRO (especificar)",
            value: "N/A",
        },
        {
            label: "revelador",
            type: "multiselect",
            textLabel: "REVELADOR",
            value: [],
            options: ["CAL", "EN SOLUCION NO ACUOSA", "OTRO"],
        },
        {
            label: "revelador_otro",
            type: "text",
            textLabel: "REVELADOR - OTRO (especificar)",
            value: "N/A",
        },
        {
            label: "iluminacion",
            type: "multiselect",
            textLabel: "ILUMINACIÓN",
            value: [],
            options: ["VISIBLE", "LIMITADA"],
        },
        {
            label: "parametros_secado_tiempo",
            type: "text",
            textLabel: "PARÁMETROS - SECADO - TIEMPO DE PERMANENCIA",
            value: "",
        },
        {
            label: "parametros_secado_temperatura",
            type: "text",
            textLabel: "PARÁMETROS - SECADO - TEMP. °C (PIEZA)",
            value: "",
        },
        {
            label: "parametros_secado_metodo_aplicacion",
            type: "text",
            textLabel: "PARÁMETROS - SECADO - MÉTODO APLICACIÓN",
            value: "",
        },
        {
            label: "parametros_secado_iluminacion",
            type: "text",
            textLabel: "PARÁMETROS - SECADO - ILUMINACIÓN",
            value: "",
        },
        {
            label: "parametros_penetracion_tiempo",
            type: "text",
            textLabel: "PARÁMETROS - PENETRACIÓN - TIEMPO DE PERMANENCIA",
            value: "",
        },
        {
            label: "parametros_penetracion_temperatura",
            type: "text",
            textLabel: "PARÁMETROS - PENETRACIÓN - TEMP. °C (PIEZA)",
            value: "",
        },
        {
            label: "parametros_penetracion_metodo_aplicacion",
            type: "text",
            textLabel: "PARÁMETROS - PENETRACIÓN - MÉTODO APLICACIÓN",
            value: "",
        },
        {
            label: "parametros_penetracion_iluminacion",
            type: "text",
            textLabel: "PARÁMETROS - PENETRACIÓN - ILUMINACIÓN",
            value: "",
        },
        {
            label: "parametros_revelado_tiempo",
            type: "text",
            textLabel: "PARÁMETROS - REVELADO - TIEMPO DE PERMANENCIA",
            value: "",
        },
        {
            label: "parametros_revelado_temperatura",
            type: "text",
            textLabel: "PARÁMETROS - REVELADO - TEMP. °C (PIEZA)",
            value: "",
        },
        {
            label: "parametros_revelado_metodo_aplicacion",
            type: "text",
            textLabel: "PARÁMETROS - REVELADO - MÉTODO APLICACIÓN",
            value: "",
        },
        {
            label: "parametros_revelado_iluminacion",
            type: "text",
            textLabel: "PARÁMETROS - REVELADO - ILUMINACIÓN",
            value: "",
        },
        {
            label: "fabricante_limpiador",
            type: "text",
            textLabel: "FABRICANTE - LIMPIADOR",
            value: "",
        },
        {
            label: "ref_comercial_limpiador",
            type: "text",
            textLabel: "REF. COMERCIAL - LIMPIADOR",
            value: "",
        },
        {
            label: "lote_limpiador",
            type: "text",
            textLabel: "LOTE No. - LIMPIADOR",
            value: "",
        },
        {
            label: "fabricante_penetracion",
            type: "text",
            textLabel: "FABRICANTE - PENETRACIÓN",
            value: "",
        },
        {
            label: "ref_comercial_penetracion",
            type: "text",
            textLabel: "REF. COMERCIAL - PENETRACIÓN",
            value: "",
        },
        {
            label: "lote_penetracion",
            type: "text",
            textLabel: "LOTE No. - PENETRACIÓN",
            value: "",
        },
        {
            label: "fabricante_revelado",
            type: "text",
            textLabel: "FABRICANTE - REVELADO",
            value: "",
        },
        {
            label: "ref_comercial_revelado",
            type: "text",
            textLabel: "REF. COMERCIAL - REVELADO",
            value: "",
        },
        {
            label: "lote_revelado",
            type: "text",
            textLabel: "LOTE No. - REVELADO",
            value: "",
        },
        {
            label: "observaciones",
            type: "textLong",
            textLabel: "OBSERVACIONES",
            value: "",
        },
        {
            label: "detalle_area_inspeccionada",
            type: "textLong",
            textLabel: "DETALLE DEL ÁREA INSPECCIONADA",
            value: "",
        },
        {
            label: "concepto_ensayo",
            type: "select",
            textLabel: "CONCEPTO DE ENSAYO",
            value: "",
            options: [
                { label: "SATISFACTORIO", value: "satisfactorio" },
                { label: "NO SATISFACTORIO", value: "no_satisfactorio" }
            ],
        },
    ],
});

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
