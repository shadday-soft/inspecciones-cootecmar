<template>
  <AppLayout title="Solicitudes de Inspecciones">
    <Datatable
      :add
      :data="inspections"
      :columnas="columns"
      :actions
      title="Solicitudes de Inspección"
    >
    </Datatable>
  </AppLayout>

  <!-- modal de tareas -->
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
  <!-- End modal tareas -->
  <InspectionForm v-model="visible" :form="form" :projectsFormatted="projectsFormatted" />
  <Asignacion
    v-model="visibleAddInspector"
    :inspeccion="inspeccion"
    v-if="inspeccion"
    :users="users"
  >
  </Asignacion>
  <Show
    v-model="visibleDetails"
    :inspeccion="inspeccionShow"
    v-if="inspeccionShow"
  ></Show>

  <!-- <Index></Index> -->
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Datatable from "@/Components/Customs/Datatable.vue";
import Modal from "@/Components/Customs/Modal.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import InspectionForm from "./InspectionForm.vue";
import Asignacion from "./Asignacion.vue";
import List from "@/Pages/Tasks/List.vue";
import Show from "./show.vue";

// Importar piezas extraídas
import initialForm from "./formData";
import columns from "./columns";
import createActions from "./actions";

const visible = ref(false);
const visibleAddInspector = ref(false);
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
  projects: {
    type: Array,
    Required: true,
  },
  inspectionToShow: {
    type: Object,
    default: null,
  },
});

if (props.inspectionToShow) {
  inspeccionShow.value = props.inspectionToShow;
  visibleDetails.value = true;
}

const form = useForm(initialForm);

const projectsFormatted = computed(() => {
  return props.projects.map((project) => ({
    ...project,
    display_name: `${project.name} (${project.code_sap})`,
  }));
});

const add = {
  action: () => {
    form.reset();
    visible.value = true;
  },
};

// Crear las acciones pasando referencias necesarias
const actions = createActions({
  form,
  visible,
  inspeccion,
  inspeccionShow,
  visibleDetails,
  visibleTareas,
  visibleAddInspector,
});
</script>
