<template>
  <div class="flex flex-col gap-y-4">
    <div class="flex gap-x-4 w-full">
      <Input
        label="Inspector"
        v-model="form.user_id"
        class="w-full"
        type="dropdown"
        :options="users"
        option-label="name"
        option-value="id"
      ></Input>
      <Input
        label="Ayudante"
        class="w-full"
        type="dropdown"
        v-model="form.ayudante_id"
        :options="users.filter((u) => u.id != form.user_id)"
        option-label="name"
        option-value="id"
      ></Input>
    </div>
    <div class="flex justify-between w-full items-center gap-x-2">
      <Input
        type="datetime"
        class="w-full"
        v-model="form.date"
        label="Fecha y hora de programación"
      ></Input>
      <Input
        class="w-full"
        type="dropdown"
        option-label="lavel"
        option-value="value"
        :options="[
          { lavel: 'Media hora', value: 0.5 },
          { lavel: '1 hora', value: 1 },
          { lavel: '1.5 hora', value: 1.5 },
          { lavel: '2 horas', value: 2 },
          { lavel: '2.5 horas', value: 2.5 },
          { lavel: '3 horas', value: 3 },
          { lavel: '4 horas', value: 4 },
          { lavel: '4.5 horasa', value: 4.5 },
          { lavel: 'Todo el Dia', value: 9.5 },
        ]"
        v-model="props.inspeccion.fecha"
        label="Duracion de la inspección"
      />
      <div
        class="flex flex-col items-center text-md font-semibold w-full"
        :class="diffIndays < 0 ? 'text-danger' : 'text-success'"
      >
        <h3>Dias de Diferencia</h3>
        {{ diffIndays }} Dias
      </div>
    </div>
    <Input
      label="Equipos"
      class="w-full"
      type="multiselect"
      v-model="form.tools"
      :options="tools"
      option-label="name"
      option-value="id"
      :loading="loadingTools"
    ></Input>
    <div class="flex justify-end">
      <!-- <Button @click="visibleAddInspector = false">Cancelar</Button> -->
      <Button label="Asignar" severity="success" @click="submit" />
    </div>
  </div>
</template>

<script setup>
import Input from "@/Components/Customs/Input.vue";
import { useForm } from "@inertiajs/vue3";
import axios from "axios";
import { computed, onMounted, ref } from "vue";
import ItemDetail from "./ItemDetail.vue";
const props = defineProps({
  users: {
    type: Array,
    required: true,
  },
  inspeccion: {
    type: Object,
    required: true,
  },
});

const form = useForm({
  user_id: null,
  ayudante_id: null,
  date: null,
  tools: [],
});

const tools = ref([]);
const loadingTools = ref(false);

const getTools = async () => {
  loadingTools.value = true;
  const { data } = await axios.get(route("tools.index"));
  tools.value = data;
  loadingTools.value = false;
};

onMounted(() => {
  getTools();
});

const diffIndays = computed(() => {
  if (!form.date) return 0;
  let fecha = form.date.split(",")[0];
  console.log(fecha);
  const dt1 = new Date(fecha);
  const dt2 = new Date(props.inspeccion.fecha);
  return Math.floor(
    (Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) -
      Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate())) /
      (1000 * 60 * 60 * 24)
  );
});

const submit = () => {
  form.post(route("inspection.assing", props.inspeccion.id));
};
</script>
