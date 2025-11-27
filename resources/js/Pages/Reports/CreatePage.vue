<template>
  <AppLayout title="Crear Nuevo Reporte">
    <div class="px-6 py-8">
      <div class="mb-6">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-bold text-gray-900">
              Crear Nuevo Reporte
            </h1>
            <p class="mt-1 text-sm text-gray-600">
              Completa el formulario para generar un nuevo reporte de inspección
            </p>
          </div>
          <Button
            @click="goBack"
            label="Volver al Listado"
            severity="secondary"
            icon="fa-solid fa-arrow-left"
            size="small"
          />
        </div>
      </div>

      <div class="bg-white shadow-sm rounded-lg p-6">
        <Create 
          :inspeccion 
          :users
          @report-created="handleReportCreated"
        />
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Create from "./Create.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  inspeccion: Object,
  users: {
    type: Array,
    default: () => []
  }
});

const goBack = () => {
  router.visit(route('inspections.show', props.inspeccion.id));
};

const handleReportCreated = () => {
  // Volver al listado de reportes de la inspección
  router.visit(route('inspections.show', props.inspeccion.id));
};
</script>
