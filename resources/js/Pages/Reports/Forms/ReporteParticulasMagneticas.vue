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

        <!-- Tabla de Especificación de los Materiales -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800 bg-gray-100">ESPECIFICACIÓN DE LOS MATERIALES</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">TIPO DE MATERIALES.</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">APL.</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">FABRICANTE</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold w-1/5">REF. COMERCIAL</th>
                        <th class="p-2 text-center font-bold w-1/5">LOTE No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">LIMPIADOR</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr class="border-b-2 border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 font-bold">PARTÍCULAS MAGNÉTICAS</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                    <tr>
                        <td class="border-r-2 border-gray-800 p-2 font-bold">PINTURA DE CONTRASTE</td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="border-r-2 border-gray-800 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Condiciones en la Inspección -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">CONDICIONES EN LA INSPECCIÓN:</h3>
            
            <!-- 1. TÉCNICA DE MAGNETIZACIÓN -->
            <div class="mb-4 border-b pb-4">
                <h4 class="font-bold mb-3">1. TÉCNICA DE MAGNETIZACIÓN</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">TIPO DE EQUIPO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'tipo_equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">MARCA:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'marca_equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">MODELO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'modelo_equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">CÓD. METROLÓGICO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'cod_metrologico_equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">FECHA DE CALIBRACIÓN:</label>
                        <input type="date" v-model="form.inputs.find(i => i.label === 'fecha_calibracion_equipo').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="font-semibold block mb-2">TIPO DE MAGNETIZACIÓN:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="LONGITUDINAL" v-model="form.inputs.find(i => i.label === 'tipo_magnetizacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>LONGITUDINAL</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="CIRCUNFERENCIAL" v-model="form.inputs.find(i => i.label === 'tipo_magnetizacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>CIRCUNFERENCIAL</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="MULTIDIRECCIONAL" v-model="form.inputs.find(i => i.label === 'tipo_magnetizacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>MULTIDIRECCIONAL</span>
                        </label>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="font-semibold block mb-2">TIPO DE CORRIENTE:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="CC" v-model="form.inputs.find(i => i.label === 'tipo_corriente').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>CC</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="CA" v-model="form.inputs.find(i => i.label === 'tipo_corriente').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>CA</span>
                        </label>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="font-semibold">AMPERAJE:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'amperaje').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" 
                        placeholder="N/A" />
                </div>
            </div>

            <!-- 2. ESPECIFICACIONES GENERALES -->
            <div class="mb-4 border-b pb-4">
                <h4 class="font-bold mb-3">2. ESPECIFICACIONES GENERALES</h4>
                
                <div class="mb-3">
                    <label class="font-semibold block mb-2">CLASE DE PARTÍCULA MAGNÉTICA:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="P. M. SECAS" v-model="form.inputs.find(i => i.label === 'clase_particula').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>P. M. SECAS</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="P. M. HÚMEDAS" v-model="form.inputs.find(i => i.label === 'clase_particula').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>P. M. HÚMEDAS</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-2">TIPO DE PARTÍCULAS:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="FLUORESCENTES" v-model="form.inputs.find(i => i.label === 'tipo_particulas').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>FLUORESCENTES</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="CONTRASTANTES" v-model="form.inputs.find(i => i.label === 'tipo_particulas').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>CONTRASTANTES</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="COLOR" v-model="form.inputs.find(i => i.label === 'tipo_particulas').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>COLOR</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-2">SECUENCIA DE APLICACIÓN DE LAS PARTÍCULAS MAGNÉTICAS:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="CONTINUA" v-model="form.inputs.find(i => i.label === 'secuencia_aplicacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>CONTINUA</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="RESIDUAL" v-model="form.inputs.find(i => i.label === 'secuencia_aplicacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>RESIDUAL</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-2">MODO DE APLICACIÓN:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="VÍA SECA" v-model="form.inputs.find(i => i.label === 'modo_aplicacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>VÍA SECA</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="VÍA HÚMEDA" v-model="form.inputs.find(i => i.label === 'modo_aplicacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>VÍA HÚMEDA</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-2">TIPO DE ILUMINACIÓN:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="NATURAL" v-model="form.inputs.find(i => i.label === 'tipo_iluminacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>NATURAL</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="BLANCA ARTIFICIAL" v-model="form.inputs.find(i => i.label === 'tipo_iluminacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>BLANCA ARTIFICIAL</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" value="ULTRAVIOLETA" v-model="form.inputs.find(i => i.label === 'tipo_iluminacion').value"
                                class="w-5 h-5 border-2 border-gray-800" />
                            <span>ULTRAVIOLETA</span>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="font-semibold block mb-2">DESMAGNETIZACIÓN:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="SÍ" v-model="form.inputs.find(i => i.label === 'desmagnetizacion').value"
                                class="w-5 h-5" />
                            <span>SÍ</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="NO" v-model="form.inputs.find(i => i.label === 'desmagnetizacion').value"
                                class="w-5 h-5" />
                            <span>NO</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="font-semibold">CAMPO RESIDUAL FINAL:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'campo_residual_final').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">TEMPERATURA DE SUPERFICIE:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura_superficie').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div>
                        <label class="font-semibold">CONCENTRACIÓN DEL BAÑO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'concentracion_bano').value"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Discontinuidades (Croquis) -->
        <div class="border-2 border-gray-800 bg-white overflow-hidden">
            <h3 class="text-lg font-bold p-3 border-b-2 border-gray-800">3. CROQUIS (Ver detalle en la Pág. 2)</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-white border-b-2 border-gray-800">
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 5%;">ITEM</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 35%;">DESCRIPCIÓN DE LA DISCONTINUIDAD</th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 15%;">FORMA<br><small>(LINEAL/REDONDA)</small></th>
                        <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 20%;">DIMENSIÓN</th>
                        <th class="p-2 text-center font-bold" style="width: 25%;">EVALUACIÓN<br><small>(ACEPTADA/RECHAZADA)</small></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="n in 6" :key="n" class="border-b border-gray-800">
                        <td class="border-r-2 border-gray-800 p-2 text-center font-bold">{{ n }}</td>
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
const detallePiezaImagen = ref(null);

// Array para discontinuidades (6 items)
const discontinuidades = ref(Array.from({ length: 6 }, () => ({
    descripcion: '',
    forma: '',
    dimension: '',
    evaluacion: ''
})));

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS",
    inputs: [
        // Campos principales
        { label: "informe_no", type: "text", textLabel: "INFORME No.", value: "" },
        { label: "fecha", type: "date", textLabel: "FECHA", value: "" },
        { label: "go_no", type: "text", textLabel: "G.O. No.", value: "" },
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
        { label: "cod_metrologico", type: "text", textLabel: "CÓD. METROLÓGICO", value: "" },
        { label: "fecha_calibracion", type: "date", textLabel: "FECHA DE CALIBRACIÓN", value: "" },
        
        // Materiales
        { label: "limpiador_apl", type: "text", textLabel: "LIMPIADOR - APL.", value: "" },
        { label: "limpiador_fabricante", type: "text", textLabel: "LIMPIADOR - FABRICANTE", value: "" },
        { label: "limpiador_ref_comercial", type: "text", textLabel: "LIMPIADOR - REF. COMERCIAL", value: "" },
        { label: "limpiador_lote", type: "text", textLabel: "LIMPIADOR - LOTE", value: "" },
        { label: "particulas_apl", type: "text", textLabel: "PARTÍCULAS - APL.", value: "" },
        { label: "particulas_fabricante", type: "text", textLabel: "PARTÍCULAS - FABRICANTE", value: "" },
        { label: "particulas_ref_comercial", type: "text", textLabel: "PARTÍCULAS - REF. COMERCIAL", value: "" },
        { label: "particulas_lote", type: "text", textLabel: "PARTÍCULAS - LOTE", value: "" },
        { label: "pintura_apl", type: "text", textLabel: "PINTURA - APL.", value: "" },
        { label: "pintura_fabricante", type: "text", textLabel: "PINTURA - FABRICANTE", value: "" },
        { label: "pintura_ref_comercial", type: "text", textLabel: "PINTURA - REF. COMERCIAL", value: "" },
        { label: "pintura_lote", type: "text", textLabel: "PINTURA - LOTE", value: "" },
        
        // Técnica de Magnetización
        { label: "tipo_equipo", type: "text", textLabel: "TIPO DE EQUIPO", value: "" },
        { label: "marca_equipo", type: "text", textLabel: "MARCA", value: "" },
        { label: "modelo_equipo", type: "text", textLabel: "MODELO", value: "" },
        { label: "cod_metrologico_equipo", type: "text", textLabel: "CÓD. METROLÓGICO EQUIPO", value: "" },
        { label: "fecha_calibracion_equipo", type: "date", textLabel: "FECHA CALIBRACIÓN EQUIPO", value: "" },
        { label: "tipo_magnetizacion", type: "multiselect", textLabel: "TIPO DE MAGNETIZACIÓN", value: [], options: ["LONGITUDINAL", "CIRCUNFERENCIAL", "MULTIDIRECCIONAL"] },
        { label: "tipo_corriente", type: "multiselect", textLabel: "TIPO DE CORRIENTE", value: [], options: ["CC", "CA"] },
        { label: "amperaje", type: "text", textLabel: "AMPERAJE", value: "" },
        
        // Especificaciones Generales
        { label: "clase_particula", type: "multiselect", textLabel: "CLASE DE PARTÍCULA", value: [], options: ["P. M. SECAS", "P. M. HÚMEDAS"] },
        { label: "tipo_particulas", type: "multiselect", textLabel: "TIPO DE PARTÍCULAS", value: [], options: ["FLUORESCENTES", "CONTRASTANTES", "COLOR"] },
        { label: "secuencia_aplicacion", type: "multiselect", textLabel: "SECUENCIA DE APLICACIÓN", value: [], options: ["CONTINUA", "RESIDUAL"] },
        { label: "modo_aplicacion", type: "multiselect", textLabel: "MODO DE APLICACIÓN", value: [], options: ["VÍA SECA", "VÍA HÚMEDA"] },
        { label: "tipo_iluminacion", type: "multiselect", textLabel: "TIPO DE ILUMINACIÓN", value: [], options: ["NATURAL", "BLANCA ARTIFICIAL", "ULTRAVIOLETA"] },
        { label: "desmagnetizacion", type: "select", textLabel: "DESMAGNETIZACIÓN", value: "" },
        { label: "campo_residual_final", type: "text", textLabel: "CAMPO RESIDUAL FINAL", value: "" },
        { label: "temperatura_superficie", type: "text", textLabel: "TEMPERATURA DE SUPERFICIE", value: "" },
        { label: "concentracion_bano", type: "text", textLabel: "CONCENTRACIÓN DEL BAÑO", value: "" },
        
        // Otros campos
        { label: "detalle_pieza", type: "textLong", textLabel: "DETALLE DE LA PIEZA", value: "" },
        { label: "observaciones", type: "textLong", textLabel: "OBSERVACIONES", value: "" },
        { label: "resultado_final", type: "select", textLabel: "RESULTADO FINAL", value: "" }
    ],
});

// Campos principales (excluyendo tablas y secciones especiales)
const mainFields = computed(() => {
    const excludedLabels = [
        'limpiador_apl', 'limpiador_fabricante', 'limpiador_ref_comercial', 'limpiador_lote',
        'particulas_apl', 'particulas_fabricante', 'particulas_ref_comercial', 'particulas_lote',
        'pintura_apl', 'pintura_fabricante', 'pintura_ref_comercial', 'pintura_lote',
        'tipo_equipo', 'marca_equipo', 'modelo_equipo', 'cod_metrologico_equipo', 'fecha_calibracion_equipo',
        'tipo_magnetizacion', 'tipo_corriente', 'amperaje',
        'clase_particula', 'tipo_particulas', 'secuencia_aplicacion', 'modo_aplicacion', 'tipo_iluminacion',
        'desmagnetizacion', 'campo_residual_final', 'temperatura_superficie', 'concentracion_bano',
        'detalle_pieza', 'observaciones', 'resultado_final'
    ];
    
    return form.inputs.filter(i => i.type !== 'textLong' && !excludedLabels.includes(i.label));
});

function handleImageUpload(event) {
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
            detallePiezaImagen.value = e.target.result;
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
