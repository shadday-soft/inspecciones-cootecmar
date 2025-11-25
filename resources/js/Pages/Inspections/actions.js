import Swal from "sweetalert2";
import { usePage } from "@inertiajs/vue3";

// Crea las acciones del datatable recibiendo referencias necesarias
export default function createActions({
    form,
    visible,
    inspeccion,
    inspeccionShow,
    visibleDetails,
    visibleTareas,
    visibleAddInspector,
}) {
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
            show: (data) => {
                return usePage().props.auth.user.id == data.user_id;
            },
            severity: "info",
            label: "Tareas",
        },
        {
            action: (data) => {
                visibleAddInspector.value = true;
                inspeccion.value = data;
            },
            icon: "fa-solid fa-user-plus text-sm",
            severity: "success",
            label: "Asignar inspector",
        },
        {
            action: (data) => {
                visible.value = true;
                form.id = data.id;
                form.gerencia = data.gerencia;
                form.project_id = data.project_id;
                form.fecha = data.fecha;
                form.tipo = data.tipo;
                form.tipo = data.tipo.split(", ");
                form.grafo = data.grafo;
                form.supervisor = data.supervisor;
                switch (data.prioridad) {
                    case "Alta":
                        form.prioridad = 1;
                        break;
                    case "Media":
                        form.prioridad = 2;
                        break;
                    case "Baja":
                        form.prioridad = 3;
                        break;
                }
                form.descripcion = data.descripcion;
            },
            severity: "info",
            icon: "fa-solid fa-pencil text-sm",
        },
        {
            action: (data) => {
                let timerInterval;
                Swal.fire({
                    title: "Quieres eliminar el registro?",
                    text: "No podrás recuperar esta información!",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    cancelButtonText: "Cancelar",
                    confirmButtonText: "Sí, eliminar",
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Eliminado!",
                            text: "El registro ha sido eliminado.",
                            icon: "success",
                            timer: 2500,
                            willClose: () => {
                                clearInterval(timerInterval);
                            },
                        });
                        form.delete(route("inspections.destroy", data.id), {
                            onSuccess: () => {
                                form.reset();
                            },
                        });
                    }
                });
            },
            severity: "danger",
            icon: "fa-solid fa-trash text-sm",
        },
    ];
}
