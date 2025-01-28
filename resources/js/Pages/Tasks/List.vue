<template>
  <div class="flex flex-col gap-y-4">
    <Create @nueva-tarea="addTask" :inspeccion :task :key></Create>
    <div>
      <TransitionGroup name="list" tag="div">
        <div
          class="list-group-item w-full border-b-2 cursor-move my-2 p-4 flex justify-between items-center"
          :class="{ 'bg-green-200': element.percentDone == 100 }"
          :key="element.id"
          v-for="(element, index) in myArray"
        >
          <div class="flex flex-col text-lg">
            <p>
              {{ element.name }}
            </p>
            <p class="text-xs font-bold">{{ element.percentDone }} %</p>
          </div>
          <div class="flex gap-2">
            <Button
              text
              icon="fa-solid fa-edit"
              size="small"
              severity="primary"
              @click="edit(element)"
            ></Button>
            <Button
              icon="fa-solid fa-trash"
              text
              size="small"
              @click="deleteTask(element, index)"
              severity="danger"
            ></Button>
          </div>
        </div>
      </TransitionGroup>
    </div>
  </div>
</template>
<script setup>
import draggable from "vuedraggable";
import { ref, computed } from "vue";
import Create from "./Create.vue";
import axios from "axios";

const props = defineProps({
  inspeccion: {
    type: Object,
    required: true,
  },
});

const key = ref(0);

const myArray = ref([]);

const options = [
  {
    value: 1,
    label: "No iniciado",
  },
  {
    value: 2,
    label: "En proceso",
  },
  {
    value: 3,
    label: "Finalizado",
  },
];

const task = ref("");

const deleteTask = async (t, index) => {
  await axios.delete(route("tasks.destroy", t)).then((response) => {});
  myArray.value.splice(index, 1);
};

const edit = (taskEdit) => {
  key.value++;
  task.value = taskEdit;
};

const addTask = (t) => {
  getTasks();
  // myArray.value.push(t);
  // console.log(t);
};

const getTasks = () => {
  task.value = null;
  axios.get(route("getTasksByInspection", props.inspeccion)).then((response) => {
    myArray.value = response.data;
  });
};

getTasks();
</script>

<style>
.list-enter-active,
.list-leave-active {
  transition: all 0.5s ease;
}
.list-enter-from,
.list-leave-to {
  opacity: 0;
  transform: translateX(30px);
}
</style>
