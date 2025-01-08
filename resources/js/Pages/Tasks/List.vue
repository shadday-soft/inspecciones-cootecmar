<template>
  <div class="flex flex-col gap-y-4">
    <Create @nueva-tarea="getTasks" :inspeccion :task :key></Create>
    <div>
      <draggable
        class="w-full shadow-sm rounded-lg p-2"
        v-model="myArray"
        group="people"
        :component-data="{ tag: 'div', name: 'flip-list', type: 'transition' }"
        @start="drag = true"
        @end="endDrag"
        v-bind="dragOptons"
        item-key="id"
      >
        <template #item="{ element }">
          <div
            class="list-group-item w-full border-b-2 cursor-move my-2 p-4 flex justify-between items-center"
            :class="{ 'bg-teal-200': element.percentDone == 100 }"
          >
            <div class="flex flex-col text-lg">
              <p>
                {{ element.name }}
              </p>
              <p class="text-xs font-bold">{{ element.percentDone }} %</p>
            </div>
            <div class="flex gap-2">
              <Button
                outlined
                icon="fa-solid fa-edit"
                severity="secondary"
                @click="editTask(element)"
              ></Button>
              <Button icon="fa-solid fa-trash" outlined severity="danger"></Button>
            </div>
          </div>
        </template>
      </draggable>
    </div>
  </div>
</template>
<script setup>
import draggable from "vuedraggable";
import { ref, computed } from "vue";
import Create from "./Create.vue";

const props = defineProps({
  inspeccion: {
    type: Object,
    required: true,
  },
});

const key = ref(0);

const dragOptons = computed(() => {
  return {
    animation: 250,
    group: "description",
    disabled: false,
    ghostClass: "ghost",
  };
});

const drag = ref(false);

const endDrag = () => {
  drag.value = false;
  console.log(myArray.value);
  console.log("end drag");
};

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

const editTask = (taskEdit) => {
  key.value++;
  task.value = taskEdit;
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
.button {
  margin-top: 35px;
}

.flip-list-move {
  transition: transform 0.8s;
}

.no-move {
  transition: transform 0.1s;
}

.ghost {
  opacity: 0.2;
  @apply text-white;
  @apply bg-primary;
}

.list-group {
  min-height: 20px;
}

.list-group-item {
  cursor: move;
}

.list-group-item i {
  cursor: pointer;
}
</style>
