<template>
  <Modal v-model="visibleLocal" :title="modalTitle" close-on-escape>
    <Input
      label="Nombre"
      v-model="form.name"
      placeholder="Escriba el nombre del Equipo"
      :error-message="form.errors.name"
    ></Input>
    <Input
      label="Serial"
      v-model="form.serial"
      placeholder="Escriba el serial del equipo"
      type="string"
    ></Input>
    <Input
      label="Última calibración"
      v-model="form.last_calibration"
      placeholder="Escriba la ultima calibración"
      type="date"
    ></Input>

    <Input
      label="Descripción"
      type="textarea"
      v-model="form.description"
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
import { ref, watch } from "vue";
import Modal from "@/Components/Customs/Modal.vue";
import Input from "@/Components/Customs/Input.vue";

const props = defineProps({
  modelValue: { type: Boolean, required: true },
  form: { type: Object, required: true },
});

const emit = defineEmits(["update:modelValue"]);

const visibleLocal = ref(props.modelValue);

import Swal from "sweetalert2";
import { computed } from "vue";

const modalTitle = computed(() => {
  // Si hay id, estamos en modo edición
  if (props.form && props.form.id) {
    // Mostrar nombre si existe, si no el id
    const identifier = props.form.name || props.form.id;
    return `✏️ Editar Equipo ${identifier ? `#${identifier}` : ""}`;
  }
  return "Añadir Equipo";
});

watch(
  () => props.modelValue,
  (v) => {
    visibleLocal.value = v;
  }
);

watch(visibleLocal, (v) => emit("update:modelValue", v));

async function onSave() {
  let timerInterval;
  try {
    if (props.form.id) {
      await props.form.put(route("tools.update", props.form.id), {
        onSuccess: () => {
          visibleLocal.value = false;
          props.form.reset();
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

    await props.form.post(route("tools.store"), {
      onSuccess: () => {
        visibleLocal.value = false;
        props.form.reset();
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
  } catch (e) {
    // Puedes manejar errores adicionales aquí si lo deseas
    console.error(e);
  }
}
</script>
