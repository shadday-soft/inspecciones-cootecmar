<template>
  <Modal v-model="visibleLocal" :title="modalTitle" close-on-escape>
    <Input
      label="Nombre"
      v-model="form.name"
      placeholder="Escriba el nombre del Proyecto"
      :error-message="form.errors.name"
    ></Input>
    <Input
      label="Gerencia"
      v-model="form.gerencia"
      type="dropdown"
      :options="['GEBOC', 'GECON', 'GEMAM', 'GEDIN']"
      :errorMessage="form.errors.gerencia"
    ></Input>
    <Input
      label="Code-SAP"
      v-model="form.code_sap"
      placeholder="Escriba el Code-SAP del Proyecto"
      :error-message="form.errors.code_sap"
    ></Input>
    <Input
      label="Fecha"
      v-model="form.date"
      placeholder="Escriba la fecha del Proyecto"
      type="date"
      :error-message="form.errors.date"
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
});

const emit = defineEmits(["update:modelValue"]);

const visibleLocal = ref(props.modelValue);

watch(
  () => props.modelValue,
  (v) => (visibleLocal.value = v)
);
watch(visibleLocal, (v) => emit("update:modelValue", v));

const modalTitle = computed(() => {
  if (props.form && props.form.id) {
    const identifier = props.form.name || props.form.id;
    return `✏️ Editar Proyecto ${identifier ? `#${identifier}` : ""}`;
  }
  return "Añadir Proyecto";
});

async function onSave() {
  let timerInterval;
  try {
    if (props.form.id) {
      await props.form.put(route("projects.update", props.form.id), {
        onSuccess: () => {
          visibleLocal.value = false;
          props.form.reset();
          Swal.fire({
            title: "Actualizado!",
            text: "El registro fue actualizado con exito.",
            icon: "success",
            timer: 2500,
            willClose: () => clearInterval(timerInterval),
          });
        },
      });
      return;
    }

    await props.form.post(route("projects.store"), {
      onSuccess: () => {
        visibleLocal.value = false;
        props.form.reset();
        Swal.fire({
          title: "Guardado!",
          text: "El registro fue guardado con exito.",
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
