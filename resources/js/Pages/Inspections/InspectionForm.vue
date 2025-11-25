<template>
  <Modal v-model="visibleLocal" :title="modalTitle" close-on-escape>
    <Input label="Solicitante" v-model="form.solicitante" disabled></Input>
    <Input
      label="Gerencia"
      v-model="form.gerencia"
      :errorMessage="form.errors.gerencia"
      type="dropdown"
      :options="['GEBOC', 'GECON', 'GEMAM', 'GEDIN']"
    ></Input>

    <Input
      label="Proyecto"
      v-model="form.project_id"
      :errorMessage="form.errors.project_id"
      type="dropdown"
      option-label="display_name"
      option-value="id"
      :options="projectsFormatted"
      placeholder="Seleccione un proyecto"
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
    <Input label="Grafo" v-model="form.grafo" placeholder="xxxxxx_xx" :errorMessage="form.errors.grafo"></Input>
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
          @click="visibleLocal = false"
        ></Button>
        <Button
          label="Guardar"
          severity="success"
          icon="fa-solid fa-save"
          @click="onSave"
          :loading="form.processing"
        ></Button>
      </div>
    </template>
  </Modal>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import Modal from "@/Components/Customs/Modal.vue";
import Input from "@/Components/Customs/Input.vue";
import Swal from "sweetalert2";

const props = defineProps({
  modelValue: { type: Boolean, required: true },
  form: { type: Object, required: true },
  projectsFormatted: { type: Array, required: true },
});

const emit = defineEmits(["update:modelValue"]);

const visibleLocal = ref(props.modelValue);
watch(() => props.modelValue, (v) => (visibleLocal.value = v));
watch(visibleLocal, (v) => emit("update:modelValue", v));

const modalTitle = computed(() => (props.form && props.form.id ? 'Editar Solicitud' : 'Añadir inspección'));

async function onSave() {
  let timerInterval;
  try {
    // Convertir tipo a JSON antes de enviar (misma lógica que antes)
    const tipoValue = props.form.tipo;
    props.form.tipo = JSON.stringify(tipoValue);

    if (props.form.id) {
      await props.form.put(route("inspections.update", props.form.id), {
        onSuccess: () => {
          visibleLocal.value = false;
          props.form.reset();
          Swal.fire({
            title: "Editado",
            text: "El registro ha sido editado!",
            icon: "success",
            timer: 2500,
            willClose: () => clearInterval(timerInterval),
          });
        },
      });
      return;
    }

    await props.form.post(route("inspections.store"), {
      onSuccess: () => {
        visibleLocal.value = false;
        props.form.reset();
        Swal.fire({
          title: "Guardado",
          text: "El registro ha sido guardado!",
          icon: "success",
          timer: 2500,
          willClose: () => clearInterval(timerInterval),
        });
      },
    });
  } catch (e) {
    console.error(e);
  }
}
</script>
