<template>
    <div class="flex flex-col gap-y-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div v-for="(input, index) of form.inputs.filter(i => i.type !== 'textLong')" :key="index"
                :class="input.type === 'multiselect' ? 'col-span-1 md:col-span-3' : ''">
                <label class="font-bold">{{ input.textLabel }}:</label>
                <div class="rounded-lg border border-gray-300">
                    <div v-if="input.type == 'multiselect'" class="p-3 flex gap-4">
                        <div v-for="option in input.options" :key="option" class="flex items-center gap-2">
                            <input type="checkbox" :value="option" v-model="input.value"
                                :id="`${input.label}_${option}`"
                                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                            <label :for="`${input.label}_${option}`" class="font-normal">{{ option }}</label>
                        </div>
                    </div>
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
    </div>
    <div class="flex justify-end gap-x-2 mt-2">
        <Button @click="submit" label="Guardar" severity="success" size="small" icon="fa-solid fa-save" />
        <Button label="Cancelar" severity="danger" size="small" icon="fa-solid fa-xmark" />
    </div>
</template>
<script setup>
import { useForm, usePage } from "@inertiajs/vue3";

const props = defineProps({
    inspeccion: Object,
});

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN",
    inputs: [
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
        // {
        //     label: "inspeccion_realizada_por",
        //     type: "text",
        //     textLabel: "INSPECCIÓN REALIZADA POR",
        //     value: usePage().props.auth.user.name
        // },
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
            label: "instrumento_medicion_codigo",
            type: "text",
            textLabel: "INSTRUMENTO DE MEDICIÓN - CÓDIGO METROLÓGICO",
            value: "",
        },
        {
            label: "fecha_calibracion_medicion",
            type: "text",
            textLabel: "FECHA DE CALIBRACIÓN",
            value: "",
        },
        {
            label: "regulacion_aplicada",
            type: "textLong",
            textLabel: "REGULACIÓN APLICADA",
            value: "",
        },
        {
            label: "resultado_prueba",
            type: "text",
            textLabel: "RESULTADO DE LA PRUEBA",
            value: "",
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
    form.post(route("reports.store"));
}
</script>
