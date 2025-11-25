// Columnas para la tabla de Inspections
export default [
  {
    field: "code",
    header: "code",
    filter: "true",
  },
  {
    field: "solicitante",
    header: "Solicitante",
    filter: "true",
  },
  {
    field: "gerencia",
    header: "Gerencia",
    filter: "true",
  },
  {
    field: "project",
    header: "Proyecto",
    filter: "true",
    type: "html",
    renderer: (rowData) => {
      return rowData
        ? `<div class="flex flex-col">
             <span class="font-medium">${rowData.name}</span>
             <span class="text-xs text-gray-500">${rowData.code_sap}</span>
           </div>`
        : '<span class="italic text-center text-gray-400">Sin proyecto</span>';
    },
  },
  {
    field: "fecha",
    header: "Fecha",
    filter: "true",
  },
  {
    field: "tipo",
    header: "Tipo",
  },
  {
    field: "grafo",
    header: "Grafo",
    filter: "true",
  },
  {
    field: "supervisor",
    header: "Supervisor",
    filter: "true",
  },
  {
    field: "prioridad",
    header: "Prioridad",
    filter: "true",
  },
  {
    field: "descripcion",
    header: "Descripción",
  },
  {
    field: "user",
    header: "Inspector",
    type: "html",
    renderer: (rowData) => {
      return rowData
        ? `<div class="flex gap-2 text-sm items-center">
                    <img src="${rowData.profile_photo_url}" class="size-6 rounded-full" alt="avatar">
                    <p>${rowData.name}</p>
                </div>`
        : `<p class="italic text-center">Sin Asignación</p>`;
    },
  },
];
