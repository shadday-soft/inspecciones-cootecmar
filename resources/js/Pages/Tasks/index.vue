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
import Input from "@/Components/Customs/Input.vue";
import Modal from "@/Components/Customs/Modal.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import show from "@/Pages/Inspections/Show.vue";

const visible = ref(false);
const visibleAddInspector = ref(false);
const visibleDetails = ref(false);
const inspeccionShow = ref(null);

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

const form = useForm({
  id: "",
  solicitante: usePage().props.auth.user.name,
  gerencia: "",
  fecha: "",
  tipo: "",
  grafo: "",
  supervisor: "",
  prioridad: "",
  descripcion: "",
});

const add = {
  action: () => {
    form.reset();
    visible.value = true;
  },
};
const inspeccion = ref(null);
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
];
</script>
