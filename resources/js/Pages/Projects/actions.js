import Swal from "sweetalert2";

// Crea las acciones del datatable recibiendo referencias (form y visible)
export default function createActions({ form, visible }) {
  return [
    {
      action: (data) => {
        visible.value = true;
        form.id = data.id;
        form.name = data.name;
        form.gerencia = data.gerencia;
        form.code_sap = data.code_sap;
        form.date = data.date;
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
            form.delete(route("projects.destroy", data.id), {
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
