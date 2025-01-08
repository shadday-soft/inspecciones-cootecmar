<template>
  <div class="flex flex-col gap-y-4">
    <p class="font-bold text-lg">Tareas de la Inspección: {{ inspeccion.code }}</p>
    <div>
      <draggable
        class="w-full shadow-lg rounded-lg p-2"
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
          >
            <div class="flex flex-col text-lg">
              <p>
                {{ element.name }}
              </p>
              <p class="text-xs font-bold">No Iniciado</p>
            </div>
            <div class="flex gap-2">
              <Button label="Editar" outlined severity="secondary"></Button>
              <Button label="Quitar" outlined severity="danger"></Button>
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

const props = defineProps({
  inspeccion: {
    type: Object,
    required: true,
  },
});

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

const myArray = ref([
  { id: 1, name: "John" },
  { id: 2, name: "Joao" },
  { id: 3, name: "Jean" },
  { id: 4, name: "Juan" },
]);
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
