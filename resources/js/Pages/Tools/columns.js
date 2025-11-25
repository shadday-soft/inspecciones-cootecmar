// Columnas para la tabla de Tools
export default [
  {
    field: "name",
    header: "Nombre",
    filter: true,
  },
  {
    field: "serial",
    header: "Serial",
    type: "string",
    filter: true,
  },
  {
    field: "description",
    header: "Descripción",
    filter: true,
  },
  {
    field: "last_calibration",
    header: "Última calibración",
    type: "date",
  },
];
