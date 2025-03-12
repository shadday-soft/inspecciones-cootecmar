<template>
  <div class="flex flex-col gap-y-2">
    <Input
      label="Tipo de Reporte"
      type="dropdown"
      v-model="typeSeclect"
      :options="typesReports"
    />
    <div>
      <ReporteInspeccion v-if="typeSeclect == 'Reporte de Inspección'" />
    </div>
  </div>
</template>
<script setup>
import Input from "@/Components/Customs/Input.vue";
import { ref } from "vue";
import ReporteInspeccion from "./Forms/ReporteInspeccion.vue";

const typesReports = ref(["Reporte de Inspección"]);
const typeSeclect = ref(null);
</script>
