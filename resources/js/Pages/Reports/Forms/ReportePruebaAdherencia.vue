<template>
    <div class="flex flex-col gap-y-4">
        <!-- Campos principales en grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => !['cuadricula', 'metodo_hidraulico', 'corte_en_x', 'temperatura_sustrato', 'temperatura_ambiental', 'humedad_relativa', 'punto_rocio', 'adhesivo_utilizado', 'metodo_prueba', 'localizacion_prueba', 'valor_prueba', 'numero_recubrimientos', 'duracion_prueba', 'clase_recubrimiento', 'espesor_promedio', 'perfil_anclaje', 'observaciones'].includes(i.label))" :key="index">
                <label class="font-bold">{{ input.textLabel }}:</label>
                <div class="rounded-lg border border-gray-300">
                    <input v-if="input.type == 'text'" type="text" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                    <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                        class="w-full px-3 py-2 border-0 rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección I: Método Utilizado -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">I. MÉTODO UTILIZADO</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" v-model="form.inputs.find(i => i.label === 'cuadricula').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">A. CUADRÍCULA</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" v-model="form.inputs.find(i => i.label === 'metodo_hidraulico').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">B. MÉTODO HIDRÁULICO</span>
                    </label>
                </div>
                <div class="flex items-center">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" v-model="form.inputs.find(i => i.label === 'corte_en_x').value"
                            class="w-5 h-5 border-2 border-gray-800" />
                        <span class="font-bold">C. CORTE EN X</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Sección de Equipo -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">INFORMACIÓN DEL EQUIPO</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">EQUIPO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'equipo').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">MODELO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'modelo').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">MARCA:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'marca').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">RANGO DE TRABAJO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'rango_trabajo').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">SERIE:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'serie').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">CÓDIGO METROLÓGICO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'codigo_metrologico').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección II: Condiciones Ambientales -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">II. CONDICIONES AMBIENTALES</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="font-bold">Temperatura del sustrato °C:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura_sustrato').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">Temperatura ambiental °C:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura_ambiental').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">Humedad relativa %:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'humedad_relativa').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">Punto de rocío °C:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'punto_rocio').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección III: Detalle del Sistema -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">III. DETALLE DEL SISTEMA</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-bold">ADHESIVO UTILIZADO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'adhesivo_utilizado').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">MÉTODO DE LA PRUEBA:</label>
                    <div class="flex items-center gap-4 mt-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="Destructivo" v-model="form.inputs.find(i => i.label === 'metodo_prueba').value"
                                class="w-4 h-4" />
                            <span>Destructivo</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="No Destructivo" v-model="form.inputs.find(i => i.label === 'metodo_prueba').value"
                                class="w-4 h-4" />
                            <span>No Destructivo</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-bold">LOCALIZACIÓN DE LA PRUEBA:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'localizacion_prueba').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">VALOR DE LA PRUEBA:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'valor_prueba').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="font-bold">N° DE RECUBRIMIENTOS:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'numero_recubrimientos').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">DURACIÓN DE LA PRUEBA:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'duracion_prueba').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="font-bold">CLASE DE RECUBRIMIENTO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'clase_recubrimiento').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">ESPESOR PROMEDIO:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'espesor_promedio').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
                <div>
                    <label class="font-bold">PERFIL DE ANCLAJE (MILS):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'perfil_anclaje').value"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                </div>
            </div>
        </div>

        <!-- Sección IV: Resultados -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">IV. RESULTADOS</h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="border-2 border-gray-400 px-2 py-2 text-center w-12">N°</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Espesor seco mils</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Dato inicial</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Dato final</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Resultado psi</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Porcentaje de adheridos</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Falla</th>
                            <th class="border-2 border-gray-400 px-2 py-2 text-center">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(resultado, index) in resultados" :key="index">
                            <td class="border-2 border-gray-400 px-2 py-2 text-center font-bold">
                                {{ index + 1 }}
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.espesor_seco"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.dato_inicial"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.dato_final"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.resultado_psi"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.porcentaje_adheridos"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.falla"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-2 border-gray-400 px-2 py-2">
                                <input type="text" v-model="resultado.observaciones"
                                    class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sección V: Observaciones -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">V. OBSERVACIONES</h3>
            <div>
                <textarea v-model="form.inputs.find(i => i.label === 'observaciones').value"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" rows="4"
                    placeholder="Escriba aquí las observaciones generales..."></textarea>
            </div>
        </div>

        <!-- Sección de Firmas (3 firmas) -->
        <div class="border-2 border-gray-400 rounded-lg p-4 bg-white">
            <h3 class="text-lg font-bold mb-4">FIRMAS</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Realizado -->
                <div>
                    <h4 class="font-bold mb-2">Realizado:</h4>
                    <div class="mb-2">
                        <label class="font-bold text-sm">Nombre:</label>
                        <input type="text" v-model="realizadoNombre"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="mb-2">
                        <label class="font-bold text-sm block mb-1">Firma:</label>
                        <SignatureCanvas @signature-saved="handleRealizadoSignature" />
                        <div v-if="realizadoFirma" class="mt-2">
                            <p class="text-success font-semibold text-sm">✓ Firma capturada</p>
                            <img :src="realizadoFirma" alt="Firma" class="border rounded-lg max-w-xs" />
                        </div>
                    </div>
                </div>

                <!-- Revisó -->
                <div>
                    <h4 class="font-bold mb-2">Revisó:</h4>
                    <div class="mb-2">
                        <label class="font-bold text-sm">Nombre:</label>
                        <input type="text" v-model="revisoNombre"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="mb-2">
                        <label class="font-bold text-sm block mb-1">Firma:</label>
                        <SignatureCanvas @signature-saved="handleRevisoSignature" />
                        <div v-if="revisoFirma" class="mt-2">
                            <p class="text-success font-semibold text-sm">✓ Firma capturada</p>
                            <img :src="revisoFirma" alt="Firma" class="border rounded-lg max-w-xs" />
                        </div>
                    </div>
                </div>

                <!-- Autorizó -->
                <div>
                    <h4 class="font-bold mb-2">Autorizó:</h4>
                    <div class="mb-2">
                        <label class="font-bold text-sm">Nombre:</label>
                        <input type="text" v-model="autorizoNombre"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500" />
                    </div>
                    <div class="mb-2">
                        <label class="font-bold text-sm block mb-1">Firma:</label>
                        <SignatureCanvas @signature-saved="handleAutorizoSignature" />
                        <div v-if="autorizoFirma" class="mt-2">
                            <p class="text-success font-semibold text-sm">✓ Firma capturada</p>
                            <img :src="autorizoFirma" alt="Firma" class="border rounded-lg max-w-xs" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
import SignatureCanvas from "@/Components/Customs/SignatureCanvas.vue";
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
});

const emit = defineEmits(['cancel']);

// Variables reactivas para las 3 firmas
const realizadoNombre = ref('');
const realizadoFirma = ref(null);
const revisoNombre = ref('');
const revisoFirma = ref(null);
const autorizoNombre = ref('');
const autorizoFirma = ref(null);

// Array de resultados (3 filas por defecto)
const resultados = ref([
    { espesor_seco: '', dato_inicial: '', dato_final: '', resultado_psi: '', porcentaje_adheridos: '', falla: '', observaciones: '' },
    { espesor_seco: '', dato_inicial: '', dato_final: '', resultado_psi: '', porcentaje_adheridos: '', falla: '', observaciones: '' },
    { espesor_seco: '', dato_inicial: '', dato_final: '', resultado_psi: '', porcentaje_adheridos: '', falla: '', observaciones: '' },
]);

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "PRUEBA DE ADHERENCIA",
    inputs: [
        {
            label: "informe_no",
            type: "text",
            textLabel: "INFORME N°",
            value: "",
        },
        {
            label: "planta",
            type: "text",
            textLabel: "PLANTA",
            value: "",
        },
        {
            label: "fecha",
            type: "date",
            textLabel: "FECHA",
            value: "",
        },
        {
            label: "qt_p",
            type: "text",
            textLabel: "Q.T/P°",
            value: "",
        },
        {
            label: "proyecto",
            type: "text",
            textLabel: "PROYECTO",
            value: "",
        },
        {
            label: "fecha_prueba",
            type: "date",
            textLabel: "FECHA PRUEBA",
            value: "",
        },
        {
            label: "cuadricula",
            type: "checkbox",
            textLabel: "A. CUADRÍCULA",
            value: false,
        },
        {
            label: "metodo_hidraulico",
            type: "checkbox",
            textLabel: "B. MÉTODO HIDRÁULICO",
            value: false,
        },
        {
            label: "corte_en_x",
            type: "checkbox",
            textLabel: "C. CORTE EN X",
            value: false,
        },
        {
            label: "equipo",
            type: "text",
            textLabel: "EQUIPO",
            value: "",
        },
        {
            label: "modelo",
            type: "text",
            textLabel: "MODELO",
            value: "",
        },
        {
            label: "marca",
            type: "text",
            textLabel: "MARCA",
            value: "",
        },
        {
            label: "rango_trabajo",
            type: "text",
            textLabel: "RANGO DE TRABAJO",
            value: "",
        },
        {
            label: "serie",
            type: "text",
            textLabel: "SERIE",
            value: "",
        },
        {
            label: "codigo_metrologico",
            type: "text",
            textLabel: "CÓDIGO METROLÓGICO",
            value: "",
        },
        {
            label: "temperatura_sustrato",
            type: "text",
            textLabel: "Temperatura del sustrato °C",
            value: "",
        },
        {
            label: "temperatura_ambiental",
            type: "text",
            textLabel: "Temperatura ambiental °C",
            value: "",
        },
        {
            label: "humedad_relativa",
            type: "text",
            textLabel: "Humedad relativa %",
            value: "",
        },
        {
            label: "punto_rocio",
            type: "text",
            textLabel: "Punto de rocío °C",
            value: "",
        },
        {
            label: "adhesivo_utilizado",
            type: "text",
            textLabel: "ADHESIVO UTILIZADO",
            value: "",
        },
        {
            label: "metodo_prueba",
            type: "radio",
            textLabel: "MÉTODO DE LA PRUEBA",
            value: "",
        },
        {
            label: "localizacion_prueba",
            type: "text",
            textLabel: "LOCALIZACIÓN DE LA PRUEBA",
            value: "",
        },
        {
            label: "valor_prueba",
            type: "text",
            textLabel: "VALOR DE LA PRUEBA",
            value: "",
        },
        {
            label: "numero_recubrimientos",
            type: "text",
            textLabel: "N° DE RECUBRIMIENTOS",
            value: "",
        },
        {
            label: "duracion_prueba",
            type: "text",
            textLabel: "DURACIÓN DE LA PRUEBA",
            value: "",
        },
        {
            label: "clase_recubrimiento",
            type: "text",
            textLabel: "CLASE DE RECUBRIMIENTO",
            value: "",
        },
        {
            label: "espesor_promedio",
            type: "text",
            textLabel: "ESPESOR PROMEDIO",
            value: "",
        },
        {
            label: "perfil_anclaje",
            type: "text",
            textLabel: "PERFIL DE ANCLAJE (MILS)",
            value: "",
        },
        {
            label: "observaciones",
            type: "textarea",
            textLabel: "OBSERVACIONES",
            value: "",
        },
    ],
});

// Manejadores de firmas
function handleRealizadoSignature(signatureData) {
    realizadoFirma.value = signatureData;
}

function handleRevisoSignature(signatureData) {
    revisoFirma.value = signatureData;
}

function handleAutorizoSignature(signatureData) {
    autorizoFirma.value = signatureData;
}

function submit() {
    // Validar que todos los campos de firma estén completos
    if (!realizadoNombre.value || !realizadoFirma.value ||
        !revisoNombre.value || !revisoFirma.value ||
        !autorizoNombre.value || !autorizoFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa todos los campos de las firmas antes de guardar.",
            icon: "warning",
        });
        return;
    }

    // Agregar resultados al formulario
    resultados.value.forEach((resultado, index) => {
        form.inputs.push({
            label: `resultado_${index + 1}_espesor_seco`,
            textLabel: `RESULTADO ${index + 1} - ESPESOR SECO`,
            value: resultado.espesor_seco,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_dato_inicial`,
            textLabel: `RESULTADO ${index + 1} - DATO INICIAL`,
            value: resultado.dato_inicial,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_dato_final`,
            textLabel: `RESULTADO ${index + 1} - DATO FINAL`,
            value: resultado.dato_final,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_resultado_psi`,
            textLabel: `RESULTADO ${index + 1} - RESULTADO PSI`,
            value: resultado.resultado_psi,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_porcentaje_adheridos`,
            textLabel: `RESULTADO ${index + 1} - PORCENTAJE ADHERIDOS`,
            value: resultado.porcentaje_adheridos,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_falla`,
            textLabel: `RESULTADO ${index + 1} - FALLA`,
            value: resultado.falla,
        });
        form.inputs.push({
            label: `resultado_${index + 1}_observaciones`,
            textLabel: `RESULTADO ${index + 1} - OBSERVACIONES`,
            value: resultado.observaciones,
        });
    });

    // Agregar los datos de las firmas al formulario antes de enviar
    form.inputs.push(
        {
            label: "realizado_nombre",
            textLabel: "REALIZADO - NOMBRE",
            value: realizadoNombre.value,
        },
        {
            label: "realizado_firma",
            textLabel: "REALIZADO - FIRMA",
            value: realizadoFirma.value,
        },
        {
            label: "reviso_nombre",
            textLabel: "REVISÓ - NOMBRE",
            value: revisoNombre.value,
        },
        {
            label: "reviso_firma",
            textLabel: "REVISÓ - FIRMA",
            value: revisoFirma.value,
        },
        {
            label: "autorizo_nombre",
            textLabel: "AUTORIZÓ - NOMBRE",
            value: autorizoNombre.value,
        },
        {
            label: "autorizo_firma",
            textLabel: "AUTORIZÓ - FIRMA",
            value: autorizoFirma.value,
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
