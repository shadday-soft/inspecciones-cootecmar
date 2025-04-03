<!-- <template>
  <div class="flex flex-col gap-y-2">
    <div class="flex justify-between w-full border-b items-center pb-2">
      <h1 class="font-bold text-lg">Listado de Reportes</h1>
      <Button
        @click="createReport = !createReport"
        :label="createReport ? 'Ver Listado' : 'Nuevo Reporte'"
        :severity="!createReport ? 'success' : 'primary'"
        icon="fa-solid fa-plus"
        size="small"
      />
    </div>
    
    <div v-else-if="isPending">Cargando...</div>
    <div v-else>
      <div class=""></div>
      <div class="" v-for="report of data">
        {{ report.user.name }}
      </div>
      {{ data }}
    </div>
  </div>
</template> -->

<template>
  <div class="px-2 py-6">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto">
        <h1 class="text-base font-semibold text-gray-900">Users</h1>
        <p class="text-sm text-gray-700">
          {{
            createReport
              ? "Crea un nuevo reporte para esta inspección"
              : "Listado de Reportes Generados"
          }}
        </p>
      </div>
      <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <Button
          @click="createReport = !createReport"
          :label="createReport ? 'Ver Listado' : 'Nuevo Reporte'"
          :severity="!createReport ? 'success' : 'primary'"
          icon="fa-solid fa-plus"
          size="small"
        />
      </div>
    </div>

    <div class="mt-8 flow-root">
      <Create v-if="createReport" :inspeccion></Create>
      <div v-else>
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
                  <!-- TODO: quitar el icono de editar cuando esté listo -->
                  <Button
                    text
                    severity="warn"
                    icon="fa-solid fa-pencil"
                    v-tooltip="`Editar Reporte`"
                  ></Button>
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
import { ref } from "vue";
import { useQuery } from "@tanstack/vue-query";
import Create from "./Create.vue";

const list = ref([]);

const props = defineProps({
  inspeccion: Object,
});
const createReport = ref(false);

const fetcher = async () =>
  await fetch(
    route("reports.index", {
      inspeccion: props.inspeccion.id,
    }),
    {
      headers: {
        Accept: "application/json",
        "Content-Type": "application/json",
      },
    }
  ).then((response) => response.json());

const { isPending, isError, data, error, isPlaceholderData } = useQuery({
  queryKey: ["users"],
  queryFn: () => fetcher(),
  refetchInterval: 1000 * 60 * 2,
});
</script>
