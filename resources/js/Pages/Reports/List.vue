<template>
  <div class="flex flex-col gap-y-2">
    <div class="flex justify-between w-full border-b items-center pb-2">
      <h1 class="font-bold text-lg">Listado de Reportes</h1>
      <Button
        @click="createReport = !createReport"
        :label="createReport ? 'Ver Listado' : 'Nuevo Reporte'"
        :severity="!createReport ? 'success' : 'primary'"
        icon="fa-solid fa-plus"
        size="small"
      />
    </div>
    <Create v-if="createReport"></Create>
    <div v-else>Aqui va la tabla</div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import Create from "./Create.vue";

const createReport = ref(false);
</script>
