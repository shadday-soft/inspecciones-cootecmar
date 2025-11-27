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

    <!-- Sección de Firmas -->
    <SignatureSection 
      v-model:elaborado-por-nombre="elaboradoPorNombre"
      v-model:elaborado-por-cargo="elaboradoPorCargo"
      v-model:elaborado-por-firma="elaboradoPorFirma"
      v-model:revisado-por-nombre="revisadoPorNombre"
      v-model:revisado-por-cargo="revisadoPorCargo"
      v-model:revisado-por-firma="revisadoPorFirma"
    />
  </div>
  <div class="flex justify-end gap-x-2 mt-2">
    <Button
      @click="submit"
      label="Guardar"
      severity="success"
      size="small"
      icon="fa-solid fa-save"
      :loading="form.processing"
      :disabled="form.processing"
    />
    <Button 
      label="Cancelar" 
      severity="danger" 
      size="small" 
      icon="fa-solid fa-xmark"
      :disabled="form.processing"
      @click="$emit('cancel')"
    />
  </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "axios";
import { useForm, router } from "@inertiajs/vue3";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
import Swal from "sweetalert2";

const props = defineProps({
  inspeccion: Object,
});

const emit = defineEmits(['cancel']);

// Variables reactivas para las firmas
const elaboradoPorNombre = ref('');
const elaboradoPorCargo = ref('');
const elaboradoPorFirma = ref(null);
const revisadoPorNombre = ref('');
const revisadoPorCargo = ref('');
const revisadoPorFirma = ref(null);

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
  // Validar que todos los campos de firma estén completos
  if (!elaboradoPorNombre.value || !elaboradoPorCargo.value || !elaboradoPorFirma.value ||
      !revisadoPorNombre.value || !revisadoPorCargo.value || !revisadoPorFirma.value) {
    Swal.fire({
      title: "Campos incompletos",
      text: "Por favor completa todos los campos de las firmas antes de guardar.",
      icon: "warning",
    });
    return;
  }

  // Agregar los datos de las firmas al formulario antes de enviar
  form.inputs.push(
    {
      label: "elaborado_por_nombre",
      textLabel: "ELABORADO POR - NOMBRE",
      value: elaboradoPorNombre.value,
    },
    {
      label: "elaborado_por_cargo",
      textLabel: "ELABORADO POR - CARGO",
      value: elaboradoPorCargo.value,
    },
    {
      label: "elaborado_por_firma",
      textLabel: "ELABORADO POR - FIRMA",
      value: elaboradoPorFirma.value,
    },
    {
      label: "revisado_por_nombre",
      textLabel: "REVISADO Y AUTORIZADO POR - NOMBRE",
      value: revisadoPorNombre.value,
    },
    {
      label: "revisado_por_cargo",
      textLabel: "REVISADO Y AUTORIZADO POR - CARGO",
      value: revisadoPorCargo.value,
    },
    {
      label: "revisado_por_firma",
      textLabel: "REVISADO Y AUTORIZADO POR - FIRMA",
      value: revisadoPorFirma.value,
    }
  );

  form.post(route("reports.store"), {
    onSuccess: () => {
      Swal.fire({
        title: "¡Guardado!",
        text: "El reporte se ha creado correctamente.",
        icon: "success",
        timer: 2000,
        showConfirmButton: false,
      });
      // Emitir evento para que el componente padre maneje el cierre
      emit('cancel');
    },
    onError: (errors) => {
      Swal.fire({
        title: "Error",
        text: "No se pudo guardar el reporte. Inténtalo de nuevo.",
        icon: "error",
      });
    },
  });
}
</script>
