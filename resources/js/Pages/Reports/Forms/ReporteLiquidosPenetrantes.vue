<template>
    <div class="flex flex-col gap-y-6">
        <!-- Campos básicos del formulario -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <h4 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                <i class="fa-solid fa-clipboard-list text-blue-600 dark:text-blue-400"></i>
                Información General
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="(input, index) of form.inputs.filter(i => i.type !== 'textLong' && !['prelimpieza', 'penetrante', 'penetrante_otro', 'revelador', 'revelador_otro', 'iluminacion', 'parametros_secado_tiempo', 'parametros_secado_temperatura', 'parametros_secado_metodo_aplicacion', 'parametros_secado_iluminacion', 'parametros_penetracion_tiempo', 'parametros_penetracion_temperatura', 'parametros_penetracion_metodo_aplicacion', 'parametros_penetracion_iluminacion', 'parametros_revelado_tiempo', 'parametros_revelado_temperatura', 'parametros_revelado_metodo_aplicacion', 'parametros_revelado_iluminacion', 'fabricante_limpiador', 'ref_comercial_limpiador', 'lote_limpiador', 'fabricante_penetracion', 'ref_comercial_penetracion', 'lote_penetracion', 'fabricante_revelado', 'ref_comercial_revelado', 'lote_revelado'].includes(i.label))" :key="index"
                    :class="input.type === 'multiselect' ? 'col-span-1 md:col-span-2 lg:col-span-3' : ''">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ input.textLabel }}</label>
                    <div class="rounded-lg border border-gray-300 dark:border-gray-600 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all" :class="input.disabled ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'">
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
                        :disabled="input.disabled"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        :disabled="input.disabled"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección especial de Condiciones de Inspección -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 border-2 border-amber-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <h3 class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-gray-100 mb-5 pb-3 border-b-2 border-amber-300 dark:border-gray-600">
                <i class="fa-solid fa-cog text-amber-600 dark:text-amber-400"></i>
                CONDICIONES DE INSPECCIÓN
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- PRELIMPIEZA -->
                <CheckboxMultiple
                    label="PRELIMPIEZA:"
                    :options="['QUIMICA', 'MECANICA', 'POR SOLVENTES']"
                    v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                    icon="fa-solid fa-spray-can"
                />

            <!-- PENETRANTE -->
            <CheckboxMultiple
                label="PENETRANTE:"
                :options="['ACPM', 'LÍQUIDO PENETRANTE (COLOREADO)', 'OTRO']"
                v-model="form.inputs.find(i => i.label === 'penetrante').value"
                v-model:otro-model-value="form.inputs.find(i => i.label === 'penetrante_otro').value"
                icon="fa-solid fa-droplet"
            />

            <!-- REVELADOR -->
            <CheckboxMultiple
                label="REVELADOR:"
                :options="['CAL', 'EN SOLUCION NO ACUOSA', 'OTRO']"
                v-model="form.inputs.find(i => i.label === 'revelador').value"
                v-model:otro-model-value="form.inputs.find(i => i.label === 'revelador_otro').value"
                icon="fa-solid fa-eye"
            />

                <!-- ILUMINACIÓN -->
                <CheckboxMultiple
                    label="ILUMINACIÓN:"
                    :options="['VISIBLE', 'LIMITADA']"
                    v-model="form.inputs.find(i => i.label === 'iluminacion').value"
                    icon="fa-solid fa-lightbulb"
                />
            </div>
        </div>

        <!-- Tabla de Parámetros de Operación -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-700 dark:to-blue-800 p-4">
                <i class="fa-solid fa-sliders text-white"></i>
                PARÁMETROS DE OPERACIÓN
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">PARÁMETROS DE<br>OPERACIÓN</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">TIEMPO DE<br>PERMANENCIA</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">TEMP. °C<br>(PIEZA)</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">MÉTODO<br>APLICACIÓN</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">ILUMINACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-gray-700">
                            <i class="fa-solid fa-wind mr-2 text-blue-600 dark:text-blue-400"></i>SECADO
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_tiempo').value"
                                placeholder="Ej: 10 min"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_temperatura').value"
                                placeholder="Ej: 25°C"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_metodo_aplicacion').value"
                                placeholder="Método"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_secado_iluminacion').value"
                                placeholder="Tipo"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-green-50 dark:bg-gray-700">
                            <i class="fa-solid fa-droplet mr-2 text-green-600 dark:text-green-400"></i>PENETRACIÓN
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_tiempo').value"
                                placeholder="Ej: 15 min"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_temperatura').value"
                                placeholder="Ej: 25°C"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_metodo_aplicacion').value"
                                placeholder="Método"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_penetracion_iluminacion').value"
                                placeholder="Tipo"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="hover:bg-purple-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-purple-50 dark:bg-gray-700">
                            <i class="fa-solid fa-eye mr-2 text-purple-600 dark:text-purple-400"></i>REVELADO
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_tiempo').value"
                                placeholder="Ej: 20 min"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_temperatura').value"
                                placeholder="Ej: 25°C"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_metodo_aplicacion').value"
                                placeholder="Método"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'parametros_revelado_iluminacion').value"
                                placeholder="Tipo"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Fabricantes -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-700 dark:to-indigo-800 p-4">
                <i class="fa-solid fa-flask text-white"></i>
                ESPECIFICACIÓN DE MATERIALES
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 w-1/4 text-center font-semibold text-gray-700 dark:text-gray-300">TIPO DE MATERIAL</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300">FABRICANTE</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300">REF. COMERCIAL</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300">LOTE No.</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-cyan-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-cyan-50 dark:bg-gray-700">
                            <i class="fa-solid fa-spray-can mr-2 text-cyan-600 dark:text-cyan-400"></i>LIMPIADOR
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_limpiador').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_limpiador').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_limpiador').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-teal-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-teal-50 dark:bg-gray-700">
                            <i class="fa-solid fa-droplet mr-2 text-teal-600 dark:text-teal-400"></i>PENETRACIÓN
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_penetracion').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_penetracion').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_penetracion').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="hover:bg-pink-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-pink-50 dark:bg-gray-700">
                            <i class="fa-solid fa-eye mr-2 text-pink-600 dark:text-pink-400"></i>REVELADO
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_revelado').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_revelado').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_revelado').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Campos de texto largo -->
        <div v-for="(input, index) of form.inputs.filter(i => i.type === 'textLong')" :key="index"
             class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-align-left text-blue-600 dark:text-blue-400"></i>
                {{ input.textLabel }}
            </label>
            <div class="rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
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
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
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
            value: props.inspeccion.code || "",
            disabled: true,
        },
        {
            label: "fecha",
            type: "date",
            textLabel: "FECHA",
            value: props.inspeccion.fecha || "",
            disabled: true,
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
            value: props.inspeccion.project?.name || "",
            disabled: true,
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
            value: props.inspeccion.gerencia || "",
            disabled: true,
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
