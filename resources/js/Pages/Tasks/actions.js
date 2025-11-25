/**
 * Crea las acciones para la tabla de tareas
 * @param {Object} params - Parámetros necesarios
 * @param {Ref} params.inspeccion - Ref para la inspección actual
 * @param {Ref} params.inspeccionShow - Ref para la inspección a mostrar
 * @param {Ref} params.visibleDetails - Ref para controlar visibilidad de detalles
 * @param {Ref} params.visibleTareas - Ref para controlar visibilidad de tareas
 * @returns {Array} Array de acciones
 */
export function createActions({ inspeccion, inspeccionShow, visibleDetails, visibleTareas }) {
  return [
    {
      action: (data) => {
        inspeccionShow.value = data;
        visibleDetails.value = true;
      },
      icon: "fa-solid fa-eye text-sm",
      severity: "info",
      label: "Ver detalles",
    },
    {
      action: (data) => {
        inspeccion.value = data;
        visibleTareas.value = true;
      },
      icon: "fa-solid fa-list text-sm",
      severity: "info",
      label: "Tareas",
    },
  ];
}
