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
  <Modal
    v-model="visible"
    :title="form.id ? 'Editar Solicitud' : 'Añadir inspección'"
    close-on-escape
  >
    <Input label="Solicitante" v-model="form.solicitante" disabled></Input>
    <Input
      label="Gerencia"
      v-model="form.gerencia"
      :errorMessage="form.errors.gerencia"
      type="dropdown"
      :options="['GEBOC', 'GECON', 'GEMAM', 'GEDIN']"
    ></Input>
    <Input label="Fecha" type="date" v-model="form.fecha" min-date="new Date()"></Input>
    <Input
      label="Tipo"
      v-model="form.tipo"
      type="multiselect"
      :options="[
        'Líquidos penetrantes',
        'Partículas magnéticas',
        'Ultrasonido',
        'Medición de espesores',
        'Medición de flujo',
        'Medición de vibraciones',
        'Termografía',
        'Análisis químico',
        'Medición de rugosidad',
        'Prueba de presión',
        'Prueba de fugas por ultrasonido',
        'Inspección visual',
        'Control dimensional',
        'Medición de dureza',
      ]"
    ></Input>
    <Input label="Grafo" v-model="form.grafo" placeholder="xxxxxx_xx"></Input>
    <Input
      label="Supervisor"
      v-model="form.supervisor"
      placeholder="Escriba aquí el nombre del supervisor"
    ></Input>
    <Input
      label="Prioridad"
      v-model="form.prioridad"
      option-label="name"
      option-value="value"
      type="dropdown"
      :options="[
        { name: 'Alta', value: 1 },
        { name: 'Media', value: 2 },
        { name: 'Baja', value: 3 },
      ]"
    ></Input>
    <Input
      label="Descripción"
      type="textarea"
      v-model="form.descripcion"
      placeholder="Escriba una descripción"
    ></Input>
    <template #footer>
      <div class="flex gap-x-2">
        <Button
          label="Cancelar"
          severity="danger"
          icon="fa-solid fa-xmark"
          @click="visible = false"
        ></Button>
        <Button
          label="Guardar"
          severity="success"
          icon="fa-solid fa-save"
          @click="save()"
          :loading="form.processing"
        ></Button>
      </div>
    </template>
  </Modal>
  <Modal
    v-if="inspeccion"
    :title="`Asignar Inspector a ${inspeccion.code}`"
    v-model="visibleAddInspector"
    close-on-escape
  >
    <Asignacion :users :inspeccion />
  </Modal>
  <show
    v-model="visibleDetails"
    :inspeccion="inspeccionShow"
    v-if="inspeccionShow"
  ></show>

  <!-- <Index></Index> -->
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Datatable from "@/Components/Customs/Datatable.vue";
import Input from "@/Components/Customs/Input.vue";
import Modal from "@/Components/Customs/Modal.vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import Swal from "sweetalert2";
import Asignacion from "./Asignacion.vue";
import List from "@/Pages/Tasks/List.vue";
import Create from "@/Pages/Tasks/Create.vue";
import show from "./show.vue";

const visible = ref(false);
const visibleAddInspector = ref(false);
const visibleDetails = ref(false);
const inspeccionShow = ref(null);
const visibleTareas = ref(false);

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
  {
    field: "user",
    header: "Inspector",
    type: "html",
    renderer: (rowData) => {
      return rowData
        ? `<div class="flex gap-2 text-sm items-center">
                    <img src="${rowData.profile_photo_url}" class="size-6 rounded-full" alt="avatar">
                    <p>${rowData.name}</p>
                </div>`
        : `<p class="italic text-center">Sin Asignación</p>`;
    },
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
  {
    action: (data) => {
      inspeccion.value = data;
      visibleTareas.value = true;
    },
    icon: "fa-solid fa-list text-sm",
    show: (data) => {
      return usePage().props.auth.user.id !== data.user_id;
      console.log(data);
      return true;
    },
    severity: "info",
    label: "Tareas",
  },
  {
    action: (data) => {
      visibleAddInspector.value = true;
      inspeccion.value = data;
    },
    icon: "fa-solid fa-user-plus text-sm",
    severity: "success",
    label: "Asignar inspector",
  },
  {
    action: (data) => {
      visible.value = true;
      form.id = data.id;
      form.gerencia = data.gerencia;
      form.fecha = data.fecha;
      form.tipo = data.tipo;
      form.tipo = data.tipo.split(", ");
      form.grafo = data.grafo;
      form.supervisor = data.supervisor;
      switch (data.prioridad) {
        case "Alta":
          form.prioridad = 1;
          break;
        case "Media":
          form.prioridad = 2;
          break;
        case "Baja":
          form.prioridad = 3;
          break;
      }
      form.descripcion = data.descripcion;
    },
    severity: "info",
    icon: "fa-solid fa-pencil text-sm",
  },
  {
    action: (data) => {
      let timerInterval;
      Swal.fire({
        title: "Quieres eliminar el registro?",
        text: "No podrás recuperar esta información!",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Sí, eliminar",
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: "Eliminado!",
            text: "El registro ha sido eliminado.",
            icon: "success",
            timer: 2500,
            willClose: () => {
              clearInterval(timerInterval);
            },
          });
          form.delete(route("inspections.destroy", data.id), {
            onSuccess: () => {
              form.reset();
            },
          });
        }
      });
    },
    severity: "danger",
    icon: "fa-solid fa-trash text-sm",
  },
];

const save = () => {
  let tipo = form.tipo;
  form.tipo = JSON.stringify(tipo);
  if (form.id) {
    form.put(route("inspections.update", form.id), {
      onSuccess: () => {
        visible.value = false;
        form.reset();
        let timerInterval;
        Swal.fire({
          title: "Editado",
          text: "El registro ha sido editado!",
          icon: "success",
          timer: 2500,
          willClose: () => {
            clearInterval(timerInterval);
          },
        });
      },
    });
    return;
  }
  form.post(route("inspections.store"), {
    onSuccess: () => {
      visible.value = false;
      form.reset();
      let timerInterval;
      Swal.fire({
        title: "Guardado",
        text: "El registro ha sido guardado!",
        icon: "success",
        timer: 2500,
        willClose: () => {
          clearInterval(timerInterval);
        },
      });
    },
  });
};
</script>
