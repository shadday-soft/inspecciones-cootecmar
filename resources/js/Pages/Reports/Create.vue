<template>
  <div class="flex flex-col gap-y-2">
    <Input
      label="Tipo de Reporte"
      type="dropdown"
      v-model="typeSeclect"
      :options="typesReports"
    />
    <div>
      <ReporteInspeccion v-if="typeSeclect == 'Reporte de Inspección'" :inspeccion />
      <ReporteHermeticidad v-if="typeSeclect == 'REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN'" :inspeccion />
    </div>
  </div>
</template>
<script setup>
import Input from "@/Components/Customs/Input.vue";
import { ref } from "vue";
import ReporteInspeccion from "./Forms/ReporteInspeccion.vue";
import ReporteHermeticidad from "./Forms/ReporteHermeticidad.vue";
const typesReports = ref(["Reporte de Inspección", "REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN"]);
const typeSeclect = ref(null);

const props = defineProps({
  inspeccion: Object,
});
</script>
