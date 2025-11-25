<template>
  <AppLayout title="Equipos">
    <Datatable :add :data="tools" :columnas="columns" :actions title="Listado de equipos">
    </Datatable>
  </AppLayout>
  <ToolForm v-model="visible" :form="form" />
</template>

<script setup>
import Datatable from "@/Components/Customs/Datatable.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

// Importar piezas extraídas
import initialForm from "./formData";
import columns from "./columns";
import createActions from "./actions";
import ToolForm from "./ToolForm.vue";

const visible = ref(false);

const props = defineProps({
  tools: {
    type: Array,
    required: true,
  },
});


const form = useForm(initialForm);

const add = {
  action: () => {
    visible.value = true;
  },
};


const actions = createActions({ form, visible });

</script>
