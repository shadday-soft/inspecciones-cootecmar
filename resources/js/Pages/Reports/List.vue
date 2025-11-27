<template>
  <div class="px-2 py-6">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold text-gray-900">
          Listado de Reportes Generados
        </h1>
        <p class="text-sm text-gray-700">
         
        </p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <Button
          @click="goToCreateReport"
          label="Nuevo Reporte"
          severity="success"
          icon="fa-solid fa-plus"
          size="small"
        />
      </div>
    </div>

    <div class="mt-8 flow-root">
      <div>
        <div class="inline-block min-w-full align-middle">
          <table class="min-w-full divide-y divide-gray-300">
            <thead>
              <tr>
                <th
                  scope="col"
                  class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 lg:pl-8"
                >
                  Usuarios
                </th>
                <th
                  scope="col"
                  class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                  Tipo de Reporte
                </th>
                <th
                  scope="col"
                  class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                  Estado
                </th>
                <th
                  scope="col"
                  class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                >
                  Fecha de Creación
                </th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 lg:pr-8">
                  <span class="sr-only">Edit</span>
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="inspection in data" :key="inspection.id">
                <td
                  class="whitespace-nowrap py-1 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 lg:pl-8"
                >
                  {{ inspection.user.name }}
                </td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                  {{ inspection.type }}
                </td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                  {{ inspection.status }}
                </td>
                <td class="whitespace-nowrap px-3 py-1 text-sm text-gray-500">
                  {{ inspection.created_at }}
                </td>
                <td
                  class="relative whitespace-nowrap py-1 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 lg:pr-8"
                >
                  <a
                    target="_blank"
                    :href="route('export.report-inspeccion', inspection.id)"
                  >
                    <Button
                      text
                      icon="fa-solid fa-file-pdf"
                      v-tooltip="`Descargar Reporte`"
                    ></Button>
                  </a>
                  <Button
                    text
                    severity="danger"
                    icon="fa-solid fa-trash"
                    @click="deleteReport(inspection)"
                    v-tooltip="`Eliminar Reporte`"
                  ></Button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

const list = ref([]);

const props = defineProps({
  inspeccion: Object,
  users: {
    type: Array,
    default: () => []
  }
});

import axios from "axios";

const data = ref([]);
const isPending = ref(true);
const isError = ref(false);
const error = ref(null);

const fetchReports = async () => {
  isPending.value = true;
  isError.value = false;
  try {
    const response = await axios.get(route("reports.index", {
      inspeccion: props.inspeccion.id,
    }), {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    });
    data.value = response.data;
  } catch (err) {
    isError.value = true;
    error.value = err;
  } finally {
    isPending.value = false;
  }
};

const deleteReport = (report) => {
  Swal.fire({
    title: "¿Eliminar este reporte?",
    text: `Se eliminará el reporte de ${report.type}. Esta acción no se puede deshacer.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(route("reports.destroy", report.id), {
        onSuccess: () => {
          Swal.fire({
            title: "¡Eliminado!",
            text: "El reporte ha sido eliminado correctamente.",
            icon: "success",
            timer: 2000,
            showConfirmButton: false,
          });
          // Recargar la lista de reportes
          fetchReports();
        },
        onError: () => {
          Swal.fire({
            title: "Error",
            text: "No se pudo eliminar el reporte. Inténtalo de nuevo.",
            icon: "error",
          });
        },
      });
    }
  });
};

const goToCreateReport = () => {
  router.visit(route('reports.create', { inspection_id: props.inspeccion.id }));
};

onMounted(fetchReports);
</script>
