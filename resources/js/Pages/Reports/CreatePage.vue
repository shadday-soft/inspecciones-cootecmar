<template>
  <AppLayout title="Crear Nuevo Reporte">
    <div class="px-2 py-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-xl font-bold text-gray-900">
              Crear Nuevo Reporte
            </h1>
            <p class="mt-1 text-sm text-gray-600">
              Completa el formulario para generar un nuevo reporte de inspección
            </p>
          </div>
          
        </div>

      <div class="bg-white shadow-sm rounded-lg mt-4">
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
