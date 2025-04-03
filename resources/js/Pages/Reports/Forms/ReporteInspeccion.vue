<template>
  <div class="flex flex-col gap-y-4">
    <!-- {{ inspeccion }} -->
    <div v-for="(input, index) of form.inputs" :key="index">
      <label for="" class="font-bold">{{ input.textLabel }}:</label>
      <div class="rounded-lg border border-gray-300">
        <QuillEditor
          theme="snow"
          v-if="input.type == 'textLong'"
          v-model:content="input.value"
          contentType="html"
          toolbar="full"
        />
      </div>
    </div>
  </div>
  <div class="flex justify-end gap-x-2 mt-2">
    <Button
      @click="submit"
      label="Guardar"
      severity="success"
      size="small"
      icon="fa-solid fa-save"
    />
    <Button label="Cancelar" severity="danger" size="small" icon="fa-solid fa-xmark" />
  </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { useForm } from "@inertiajs/vue3";
const props = defineProps({
  inspeccion: Object,
});

const form = useForm({
  inspection_id: props.inspeccion.id,
  type: "Reporte de Inspección",
  inputs: [
    {
      label: "anomaly",
      type: "textLong",
      textLabel: "Novedades presentes (ANOMALY)",
      value: "",
    },
    {
      label: "acciones",
      type: "textLong",
      textLabel: "ACCIÓN (ES) A SEGUIR Y/O ALTERNATIVAS DE SOLUCIÓN",
      value: "",
    },
  ],
});

function submit() {
  form.post(route("reports.store"));
  // axios.post(route("reports.store"), { text: text.value });
}
</script>
