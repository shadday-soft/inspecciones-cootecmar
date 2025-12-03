<template>
  <div class="bg-white dark:bg-gray-800 rounded-lg">
  
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-gray-700 dark:to-gray-600 rounded-lg p-4 mb-6 border border-blue-200 dark:border-gray-600">
      <Input
        label="Tipo de Reporte"
        type="dropdown"
        v-model="typeSeclect"
        :options="typesReports"
      />
    </div>

    <transition
      enter-active-class="transition-all duration-300 ease-out"
      enter-from-class="opacity-0 transform translate-y-4"
      enter-to-class="opacity-100 transform translate-y-0"
      leave-active-class="transition-all duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-if="typeSeclect" class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 border border-gray-200 dark:border-gray-600">
        <div class="flex items-center gap-2 mb-4 pb-3 border-b border-gray-300 dark:border-gray-600">
          <i class="fa-solid fa-file-alt text-blue-600 dark:text-blue-400"></i>
          <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
            {{ typeSeclect }}
          </h3>
        </div>

        <ReporteInspeccion 
          v-if="typeSeclect == 'Reporte de Inspección'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteHermeticidad 
          v-if="typeSeclect == 'REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteEvaluacionMaterial 
          v-if="typeSeclect == 'EVALUACIÓN DE MATERIAL CRÍTICO (HOMOLOGACIÓN)'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteLiquidosPenetrantes 
          v-if="typeSeclect == 'PRUEBA DE FUGAS MEDIANTE LIQUIDOS PENETRANTES'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteLiquidosPenetrantesDetallado 
          v-if="typeSeclect == 'REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES DETALLADO'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteParticulasMagneticas 
          v-if="typeSeclect == 'REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteUltrasonido 
          v-if="typeSeclect == 'REPORTE DE INSPECCIÓN POR ULTRASONIDO'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReporteControlDimensional 
          v-if="typeSeclect == 'CONTROL DIMENSIONAL'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
        <ReportePruebaAdherencia 
          v-if="typeSeclect == 'PRUEBA DE ADHERENCIA'" 
          :inspeccion 
          :users 
          @cancel="$emit('report-created')"
        />
      </div>
    </transition>
  </div>
</template>
<script setup>
import Input from "@/Components/Customs/Input.vue";
import { ref } from "vue";
import ReporteInspeccion from "./Forms/ReporteInspeccion.vue";
import ReporteHermeticidad from "./Forms/ReporteHermeticidad.vue";
import ReporteEvaluacionMaterial from "./Forms/ReporteEvaluacionMaterial.vue";
import ReporteLiquidosPenetrantes from "./Forms/ReporteLiquidosPenetrantes.vue";
import ReporteLiquidosPenetrantesDetallado from "./Forms/ReporteLiquidosPenetrantesDetallado.vue";
import ReporteParticulasMagneticas from "./Forms/ReporteParticulasMagneticas.vue";
import ReporteUltrasonido from "./Forms/ReporteUltrasonido.vue";
import ReporteControlDimensional from "./Forms/ReporteControlDimensional.vue";
import ReportePruebaAdherencia from "./Forms/ReportePruebaAdherencia.vue";
const typesReports = ref([
  "Reporte de Inspección", 
  "REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN",
  "EVALUACIÓN DE MATERIAL CRÍTICO (HOMOLOGACIÓN)",
  "PRUEBA DE FUGAS MEDIANTE LIQUIDOS PENETRANTES",
  "REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES DETALLADO",
  "REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS",
  "REPORTE DE INSPECCIÓN POR ULTRASONIDO",
  "CONTROL DIMENSIONAL",
  "PRUEBA DE ADHERENCIA"
]);
const typeSeclect = ref(null);

const props = defineProps({
  inspeccion: Object,
  users: {
    type: Array,
    default: () => []
  }
});

defineEmits(['report-created']);
</script>
