<template>
  <AppLayout title="Tareas">
    <Datatable
      empty-message="Sin asignaciones"
      :data="inspections"
      :columnas="columns"
      :actions
      title="Mis tareas Asignadas"
    >
    </Datatable>

    <TareasModal v-model="visibleTareas" :inspeccion="inspeccion" v-if="inspeccion" />
  </AppLayout>

  <show
    v-model="visibleDetails"
    :inspeccion="inspeccionShow"
    v-if="inspeccionShow"
  ></show>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Datatable from "@/Components/Customs/Datatable.vue";
import TareasModal from "./TareasModal.vue";
import { ref } from "vue";
import show from "@/Pages/Inspections/show.vue";

// Importar módulos extraídos
import columns from "./columns";
import { createActions } from "./actions";

const visibleDetails = ref(false);
const inspeccionShow = ref(null);
const visibleTareas = ref(false);
const inspeccion = ref(null);

const props = defineProps({
  inspections: {
    type: Array,
    Required: true,
  },
  users: {
    type: Array,
    Required: true,
  },
});

// Crear las acciones pasando referencias necesarias
const actions = createActions({
  inspeccion,
  inspeccionShow,
  visibleDetails,
  visibleTareas,
});
</script>
