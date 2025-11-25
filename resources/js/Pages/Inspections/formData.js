import { usePage } from "@inertiajs/vue3";

// Estado inicial del formulario para Inspections
export const initialForm = {
  id: "",
  solicitante: usePage().props.auth.user.name,
  gerencia: "",
  project_id: "",
  fecha: "",
  tipo: "",
  grafo: "",
  supervisor: "",
  prioridad: "",
  descripcion: "",
};

export default initialForm;
