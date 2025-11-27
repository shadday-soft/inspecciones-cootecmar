<template>
    <div class="flex flex-col gap-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => i.type !== 'textLong')" :key="index"
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
    type: "REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN",
    inputs: [
        {
            label: "go_number",
            type: "text",
            textLabel: "G.O. No.",
            value: "",
        },
        {
            label: "registro_number",
            type: "text",
            textLabel: "REGISTRO No.",
            value: "",
        },
        {
            label: "tipo_prueba",
            type: "multiselect",
            textLabel: "TIPO DE PRUEBA",
            value: [],
            options: ["HIDROSTATICA", "NEUMATICA", "VACIO"],
        },
        {
            label: "montaje_dispositivo",
            type: "multiselect",
            textLabel: "MONTAJE DEL DISPOSITIVO DE LA PRUEBA",
            value: [],
            options: [
                "Division de Soldadura",
                "Division de Motores",
                "Division de Mecánica",
                "Casco y Estructura - Maquinaria Propulsion y Electricidad",
                "Contratista",
                "Otro"
            ],
        },
        {
            label: "montaje_otro",
            type: "text",
            textLabel: "MONTAJE OTRO (especificar)",
            value: "",
        },
        {
            label: "instrumento_medicion",
            type: "text",
            textLabel: "INSTRUMENTO DE MEDICIÓN",
            value: "",
        },
        {
            label: "rango",
            type: "text",
            textLabel: "RANGO",
            value: "",
        },
        {
            label: "unidad_medida",
            type: "text",
            textLabel: "UNIDAD DE MEDIDA",
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
            label: "equipo_medio_utilizado",
            type: "text",
            textLabel: "EQUIPO Y MEDIO UTILIZADO",
            value: "",
        },
        {
            label: "equipo_pieza_inspeccionar",
            type: "text",
            textLabel: "EQUIPO / PIEZA A INSPECCIONAR",
            value: "",
        },
        {
            label: "zona_inspeccionar",
            type: "text",
            textLabel: "ZONA A INSPECCIONAR",
            value: "",
        },
        {
            label: "material",
            type: "text",
            textLabel: "MATERIAL",
            value: "",
        },
        {
            label: "presion_diseno",
            type: "text",
            textLabel: "PRESIÓN DE DISEÑO",
            value: "",
        },
        {
            label: "presion_prueba",
            type: "text",
            textLabel: "PRESIÓN DE PRUEBA",
            value: "",
        },
        {
            label: "tiempo_permanencia",
            type: "text",
            textLabel: "TIEMPO DE PERMANENCIA",
            value: "",
        },
        {
            label: "factor_relacion",
            type: "text",
            textLabel: "FACTOR DE RELACIÓN",
            value: "",
        },
        {
            label: "temperatura_prueba",
            type: "text",
            textLabel: "TEMPERATURA DE PRUEBA",
            value: "",
        },
        {
            label: "temperatura_recomendada",
            type: "text",
            textLabel: "TEMPERATURA RECOMENDADA",
            value: "",
        },
        {
            label: "instrumento_medicion_temp",
            type: "text",
            textLabel: "INSTRUMENTO DE MEDICIÓN (TEMPERATURA)",
            value: "",
        },
        {
            label: "codigo_metrologico_temp",
            type: "text",
            textLabel: "CÓDIGO METROLÓGICO (TEMPERATURA)",
            value: "",
        },
        {
            label: "fecha_calibracion_temp",
            type: "date",
            textLabel: "FECHA DE CALIBRACIÓN (TEMPERATURA)",
            value: "",
        },
        {
            label: "regulacion_aplicada",
            type: "textLong",
            textLabel: "REGULACIÓN APLICADA",
            value: "Rules and Regulations for the classification of ships Part II Hull Structures of Bureau Veritas. Section 3-04 Structural and Tightness Testing",
        },
        {
            label: "resultado_prueba",
            type: "select",
            textLabel: "RESULTADO DE LA PRUEBA",
            value: "",
            options: [
                { label: "SATISFACTORIO", value: "satisfactorio" },
                { label: "NO SATISFACTORIO", value: "no_satisfactorio" }
            ],
        },
        {
            label: "observaciones",
            type: "textLong",
            textLabel: "OBSERVACIONES",
            value: "",
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
            // Emitir evento para que el componente padre maneje el cierre
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
