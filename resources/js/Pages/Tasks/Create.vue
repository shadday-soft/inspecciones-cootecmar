<template>
  <div class="border p-4 shadow-md flex flex-col gap-y-2">
    <div class="flex justify-between items-center gap-x-4">
      <Input label="Titulo de la tarea" class="w-full" v-model="name"></Input>
      <Input
        v-if="task"
        label="Avance"
        class="w-full"
        type="dropdown"
        :options="options"
        option-label="label"
        option-value="value"
        v-model="percentDone"
      ></Input>
    </div>
    <div class="flex gap-2 w-full justify-between">
      <Button label="Limpiar" severity="danger"></Button>
      <Button label="Actualizar" severity="warn" v-if="task" @click="update"></Button>
      <Button label="Añadir" severity="success" v-else @click="store"></Button>
    </div>
  </div>
</template>
<script setup>
import { ref, defineEmits } from "vue";
import Input from "@/Components/Customs/Input.vue";
import axios from "axios";

const emit = defineEmits(["nueva-tarea"]);
const props = defineProps({
  inspeccion: {
    type: Object,
    required: true,
  },
  task: {
    type: Object,
    required: false,
  },
});
const name = ref(props.task ? props.task.name : "");
const percentDone = ref(props.task ? props.task.percentDone : null);

const options = [
  {
    value: 0,
    label: "No iniciado",
  },
  {
    value: 50,
    label: "En proceso",
  },
  {
    value: 100,
    label: "Finalizado",
  },
];

const store = async () => {
  let { data } = await axios.post(route("tasks.store"), {
    name: name.value,
    percentDone: percentDone.value,
    inspection_id: props.inspeccion.id,
  });
  // console.log(data.task);
  emit("nueva-tarea", data.task);

  name.value = "";
  percentDone.value = null;
};

const update = async () => {
  let task = await axios.put(route("tasks.update", { task: props.task.id }), {
    name: name.value,
    percentDone: percentDone.value,
  });
  console.log(task);
  emit("nueva-tarea", task);
  name.value = "";
  percentDone.value = null;
};
</script>
