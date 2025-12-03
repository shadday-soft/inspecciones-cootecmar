<template>
    <div class="flex flex-col gap-y-6">
        <!-- Campos principales en grid -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <h4 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                <i class="fa-solid fa-clipboard-list text-blue-600 dark:text-blue-400"></i>
                Información General
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="(input, index) of mainFields" :key="index">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ input.textLabel }}</label>
                    <div class="rounded-lg border border-gray-300 dark:border-gray-600 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all" :class="input.disabled ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'">
                        <input v-if="input.type == 'text'" type="text" v-model="input.value"
                            :disabled="input.disabled"
                            class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                        <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                            :disabled="input.disabled"
                            class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Tipo de Materiales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 dark:from-purple-700 dark:to-purple-800 p-4">
                <i class="fa-solid fa-flask text-white"></i>
                ESPECIFICACIÓN DE MATERIALES
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/4">TIPO DE MATERIAL</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300">FABRICANTE</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300">REF. COMERCIAL</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300">LOTE No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-green-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-green-50 dark:bg-gray-700">
                            <i class="fa-solid fa-droplet mr-2 text-green-600 dark:text-green-400"></i>PENETRANTE
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_penetrante').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_penetrante').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_penetrante').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-blue-50 dark:bg-gray-700">
                            <i class="fa-solid fa-flask-vial mr-2 text-blue-600 dark:text-blue-400"></i>EMULSIFICANTE
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_emulsificante').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_emulsificante').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_emulsificante').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-cyan-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-cyan-50 dark:bg-gray-700">
                            <i class="fa-solid fa-spray-can mr-2 text-cyan-600 dark:text-cyan-400"></i>LIMPIADOR/REMOVEDOR
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
                    <tr class="hover:bg-pink-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300 bg-pink-50 dark:bg-gray-700">
                            <i class="fa-solid fa-eye mr-2 text-pink-600 dark:text-pink-400"></i>REVELADOR
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'fabricante_revelador').value"
                                placeholder="Nombre del fabricante"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'ref_comercial_revelador').value"
                                placeholder="Referencia"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'lote_revelador').value"
                                placeholder="N° de lote"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Condiciones de Inspección -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-gray-800 dark:to-gray-700 border-2 border-amber-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <h3 class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-gray-100 mb-5 pb-3 border-b-2 border-amber-300 dark:border-gray-600">
                <i class="fa-solid fa-cog text-amber-600 dark:text-amber-400"></i>
                CONDICIONES DE INSPECCIÓN
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- PRELIMPIEZA -->
                <CheckboxMultiple
                    label="PRELIMPIEZA:"
                    :options="['QUÍMICA', 'MECÁNICA', 'POR SOLVENTES']"
                    v-model="form.inputs.find(i => i.label === 'prelimpieza').value"
                    icon="fa-solid fa-spray-can"
                />

                <!-- PENETRANTE -->
                <CheckboxMultiple
                    label="PENETRANTE:"
                    :options="['VISIBLE O COLOREADO', 'FLUORESCENTE', 'DUALES']"
                    v-model="form.inputs.find(i => i.label === 'penetrante_tipo').value"
                    icon="fa-solid fa-droplet"
                />

                <!-- MÉTODO REMOCIÓN DEL PENETRANTE -->
                <CheckboxMultiple
                    label="MÉTODO REMOCIÓN DEL PENETRANTE:"
                    :options="['LAVABLE-AGUA', 'POST-EMULSIFICABLE', 'SOLVENTE']"
                    v-model="form.inputs.find(i => i.label === 'metodo_remocion').value"
                    icon="fa-solid fa-shower"
                />

                <!-- REVELADOR -->
                <CheckboxMultiple
                    label="REVELADOR:"
                    :options="['POLVO SECO', 'SUSPENSIÓN NO ACUOSO', 'EN SOLUCIÓN ACUOSA', 'SUSPENSIÓN ACUOSA']"
                    v-model="form.inputs.find(i => i.label === 'revelador_tipo').value"
                    icon="fa-solid fa-eye"
                />

                <!-- ILUMINACIÓN -->
                <CheckboxMultiple
                    label="ILUMINACIÓN:"
                    :options="['VISIBLE', 'UV']"
                    v-model="form.inputs.find(i => i.label === 'iluminacion').value"
                    icon="fa-solid fa-lightbulb"
                />
            </div>
        </div>

        <!-- Tabla de Parámetros de Operación -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-700 dark:to-indigo-800 p-4">
                <i class="fa-solid fa-sliders text-white"></i>
                PARÁMETROS DE OPERACIÓN
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">PARÁMETROS</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">TIEMPO</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">TEMP. °C</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">MÉTODO</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">ILUMINACIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(param, idx) in parametrosOperacion" :key="param.key" 
                        class="border-b border-gray-200 dark:border-gray-600 hover:bg-opacity-50 transition-colors"
                        :class="{
                            'hover:bg-blue-50 dark:hover:bg-gray-700': idx === 0,
                            'hover:bg-green-50 dark:hover:bg-gray-700': idx === 1,
                            'hover:bg-purple-50 dark:hover:bg-gray-700': idx === 2,
                            'hover:bg-cyan-50 dark:hover:bg-gray-700': idx === 3,
                            'hover:bg-yellow-50 dark:hover:bg-gray-700': idx === 4,
                            'hover:bg-pink-50 dark:hover:bg-gray-700': idx === 5
                        }">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300">
                            <i class="fa-solid fa-circle mr-2 text-xs" :class="{
                                'text-blue-600': idx === 0,
                                'text-green-600': idx === 1,
                                'text-purple-600': idx === 2,
                                'text-cyan-600': idx === 3,
                                'text-yellow-600': idx === 4,
                                'text-pink-600': idx === 5
                            }"></i>{{ param.label }}
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_tiempo`).value"
                                placeholder="Ej: 10 min"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_temperatura`).value"
                                placeholder="Ej: 25°C"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_metodo`).value"
                                placeholder="Método"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === `${param.key}_iluminacion`).value"
                                placeholder="Tipo"
                                class="w-full px-2 py-1.5 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200 rounded" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Tabla de Discontinuidades -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-orange-600 to-orange-700 dark:from-orange-700 dark:to-orange-800 p-4">
                <i class="fa-solid fa-diagram-project text-white"></i>
                CROQUIS - DISCONTINUIDADES (Detalle ver Pág. 2)
            </h3>
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
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-image text-blue-600 dark:text-blue-400"></i>
                DETALLE DE LA PIEZA
            </label>
            <div class="rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-4 bg-gray-50 dark:bg-gray-700 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors">
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
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-comment-dots text-blue-600 dark:text-blue-400"></i>
                OBSERVACIONES
            </label>
            <div class="rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
                <QuillEditor theme="snow" v-model:content="form.inputs.find(i => i.label === 'observaciones').value" contentType="html" toolbar="full" />
            </div>
        </div>

        <!-- Resultado Final -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 border-2 border-green-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <label class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100 mb-4">
                <i class="fa-solid fa-clipboard-check text-green-600 dark:text-green-400 text-xl"></i>
                RESULTADO FINAL DE LA PRUEBA
            </label>
            <div class="flex gap-6">
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
import { watch, ref, computed } from "vue";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
import CheckboxMultiple from "@/Components/Customs/CheckboxMultiple.vue";
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
        { label: "informe_no", type: "text", textLabel: "INFORME No.", value: props.inspeccion.code || "", disabled: true },
        { label: "fecha", type: "date", textLabel: "FECHA", value: props.inspeccion.fecha || "", disabled: true },
        { label: "go_no", type: "text", textLabel: "G.O No.", value: "" },
        { label: "cliente", type: "text", textLabel: "CLIENTE", value: "" },
        { label: "proyecto", type: "text", textLabel: "PROYECTO", value: props.inspeccion.project?.name || "", disabled: true },
        { label: "sitio_inspeccion", type: "text", textLabel: "SITIO DE INSPECCIÓN", value: "" },
        { label: "ciudad", type: "text", textLabel: "CIUDAD", value: "" },
        { label: "especificacion", type: "text", textLabel: "ESPECIFICACIÓN (NORMA)", value: "" },
        { label: "gerencia", type: "text", textLabel: "GERENCIA", value: props.inspeccion.gerencia || "", disabled: true },
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
