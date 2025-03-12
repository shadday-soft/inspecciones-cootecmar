<template>
  <div class="flex flex-col gap-y-4">
    <div class="flex flex-col gap-y-2">
      <div class="grid grid-cols-3 gap-4 h-[40vh] overflow-y-auto py-2">
        <TransitionGroup
          name="list"
          tag="div"
          class="list-group-item shadow-lg p-4 flex flex-col rounded-lg hover:bg-blue-100"
          :class="{ 'bg-green-200 hover:bg-green-200': element.percentDone == 100 }"
          :key="element.id"
          v-for="(element, index) in myArray"
        >
          <p>
            {{ element.name }}
          </p>
          <div class="flex justify-between items-center w-full">
            <p class="text-lg font-bold">{{ element.percentDone }} %</p>
            <div>
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
      <Create @nueva-tarea="addTask" :inspeccion :task :key></Create>
    </div>
  </div>
</template>
<script setup>
import draggable from "vuedraggable";
import { ref, computed } from "vue";
import Create from "./Create.vue";
import axios from "axios";
import Swal from "sweetalert2";

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
  Swal.fire({
    title: "Quieres eliminar el registro?",
    text: "No podrás recuperar esta información!",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    cancelButtonText: "Cancelar",
    confirmButtonText: "Sí, eliminar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      await axios.delete(route("tasks.destroy", t)).then((response) => {
        myArray.value.splice(index, 1);
        Swal.fire({
          title: "Eliminado!",
          text: "El registro ha sido eliminado.",
          icon: "success",
          timer: 2500,
          willClose: () => {
            clearInterval(timerInterval);
          },
        });
      });
    }
  });
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
