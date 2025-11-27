<template>
  <div class="flex flex-col gap-y-2">
    <Input
      label="Tipo de Reporte"
      type="dropdown"
      v-model="typeSeclect"
      :options="typesReports"
    />
    <div>
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
