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
      <div class="flex flex-col w-full -mt-1">
        <label class="font-bold">Fecha y hora de Inspección</label>
        <input
          type="datetime-local"
          @input="getDateInspections"
          v-model="form.fecha_programada"
          class="rounded-md h-10"
        />
      </div>
      <Input
        class="w-full"
        type="dropdown"
        v-model="form.duracion"
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
    <div class="flex flex-col w-full">
      <h1>Equipos</h1>
      <MultiSelect
        v-model="form.tools"
        :options="tools"
        optionLabel="name"
        filter
        placeholder="Seleccionar Equipos"
        display="chip"
        class="w-full"
      >
        <template #option="slotProps">
          <div
            class="flex items-center justify-between w-full"
            :class="getDisponible(slotProps.option) == 0 ? 'text-danger ' : ''"
          >
            <div>{{ slotProps.option.name }}</div>
            <span class="font-bold text-sm"
              >{{ getDisponible(slotProps.option) }} Disponibles</span
            >
          </div>
        </template>

        <template #header>
          <div class="font-medium px-3 py-2">Equipos</div>
        </template>
        <template #footer>
          <div class="p-3 flex justify-between">
            <Button
              label="Add New"
              severity="secondary"
              text
              size="small"
              icon="pi pi-plus"
            />
            <Button
              label="Remove All"
              severity="danger"
              text
              size="small"
              icon="pi pi-times"
            />
          </div>
        </template>
      </MultiSelect>
    </div>

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
  user_id: props.inspeccion.user_id,
  ayudante_id: props.inspeccion.ayudante_id,
  fecha_programada: props.inspeccion.fecha + "T07:00",
  duracion: 0.5,
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
  if (!form.fecha_programada) return 0;
  let fecha = form.fecha_programada.split(",")[0];
  const dt1 = new Date(fecha);
  const dt2 = new Date(props.inspeccion.fecha);
  return Math.floor(
    (Date.UTC(dt2.getFullYear(), dt2.getMonth(), dt2.getDate()) -
      Date.UTC(dt1.getFullYear(), dt1.getMonth(), dt1.getDate() - 1)) /
      (1000 * 60 * 60 * 24)
  );
});

const submit = () => {
  form.post(route("inspection.assing", props.inspeccion.id));
};
const toolsDisabled = ref([]);

const getDateInspections = () => {
  loadingTools.value = true;
  axios
    .get(route("getDateInspections"), {
      params: {
        date: form.fecha_programada.split("T")[0],
      },
    })
    .then((response) => {
      loadingTools.value = false;
      toolsDisabled.value = response.data.map((t) => {
        return t.tools.map((t) => t.pivot.tool_id);
      });
      form.tools = [];
    });
};

getDateInspections();

const getDisponible = (equipo) => {
  var total = 0;
  let disponibles = 0;
  toolsDisabled.value.forEach((t) => {
    total = t.filter((t) => t == equipo.id).length + total;
  });
  return equipo.cant - total;
  // return disponibles;
};
</script>
