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

    <Modal
      v-if="inspeccion"
      :title="`Listado de tareas de la solicitud ${inspeccion.code}`"
      v-model="visibleTareas"
      closeOnEscape
    >
      <div class="flex flex-col gap-y-4">
        <List :inspeccion></List>
      </div>
    </Modal>
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
import Modal from "@/Components/Customs/Modal.vue";
import { ref } from "vue";
import show from "@/Pages/Inspections/Show.vue";
import { usePage } from "@inertiajs/vue3";

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

const columns = [
  {
    field: "code",
    header: "code",
    filter: "true",
  },
  {
    field: "solicitante",
    header: "Solicitante",
    filter: "true",
  },
  {
    field: "gerencia",
    header: "Gerencia",
    filter: "true",
  },
  {
    field: "fecha",
    header: "Fecha",
    filter: "true",
  },
  {
    field: "tipo",
    header: "Tipo",
  },
  {
    field: "grafo",
    header: "Grafo",
    filter: "true",
  },
  {
    field: "supervisor",
    header: "Supervisor",
    filter: "true",
  },
  {
    field: "prioridad",
    header: "Prioridad",
    filter: "true",
  },

  {
    field: "descripcion",
    header: "Descripción",
  },
];

const actions = [
  {
    action: (data) => {
      inspeccionShow.value = data;
      visibleDetails.value = true;
      console.log(inspeccionShow.value);
    },
    icon: "fa-solid fa-eye text-sm",
    severity: "info",
    label: "Ver detalles",
  },
  {
    action: (data) => {
      inspeccion.value = data;
      visibleTareas.value = true;
    },
    icon: "fa-solid fa-list text-sm",
    show: (data) => {
      return usePage().props.auth.user.id !== data.user_id;
    },
    severity: "info",
    label: "Tareas",
  },
];
</script>
