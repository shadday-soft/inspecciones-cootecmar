# Implementación del Selector de Proyectos

## Resumen de Cambios

Se ha implementado un selector de proyectos que reemplaza el campo de texto libre "proyecto" en el formulario de inspecciones. Ahora las inspecciones están relacionadas con proyectos específicos almacenados en la base de datos.

## Cambios Realizados

### Backend

1. **Modelo Inspection** (`app/Models/Inspection.php`)
   - Agregada relación `project()` con el modelo Project
   - La relación utiliza `project_id` como clave foránea

2. **Form Requests**
   - `StoreInspectionRequest.php`: Actualizada validación para usar `project_id` en lugar de `proyecto`
   - `UpdateInspectionRequest.php`: Actualizada validación para usar `project_id` en lugar de `proyecto`
   - Ambos incluyen validación `exists:projects,id` para verificar que el proyecto existe

3. **InspectionController** (`app/Http/Controllers/InspectionController.php`)
   - Importado modelo `Project`
   - Método `index()` actualizado para cargar la relación `project` en las inspecciones
   - Se pasan los proyectos al frontend para poblar el selector

4. **Base de Datos**
   - **Migración**: `2025_09_17_230407_update_existing_inspections_with_project_id.php`
     - Actualiza inspecciones existentes asignándoles el primer proyecto disponible
   - **Seeder**: `ProjectSeeder.php`
     - Crea 7 proyectos de ejemplo con nombres descriptivos y códigos SAP
     - Incluye proyectos de diferentes gerencias (GECON, GEBOC, GEMAM, GEDIN)

### Frontend

1. **Componente de Inspecciones** (`resources/js/Pages/Inspections/index.vue`)
   - Cambiado input de texto a dropdown para selección de proyectos
   - Agregada prop `projects` para recibir la lista de proyectos
   - Actualizado form para usar `project_id` en lugar de `proyecto`
   - Creada computed property `projectsFormatted` para mostrar nombre y código SAP
   - Actualizada columna de tabla para mostrar nombre del proyecto y código SAP
   - Actualizada lógica de edición para cargar `project_id` correcto

## Estructura de Datos

### Tabla Projects
```sql
- id (bigint, primary key)
- name (varchar) - Nombre descriptivo del proyecto
- gerencia (varchar) - Gerencia responsable (GECON, GEBOC, GEMAM, GEDIN)
- code_sap (varchar, unique) - Código SAP del proyecto
- date (varchar) - Fecha del proyecto
- created_at, updated_at (timestamps)
```

### Relación en Inspections
```sql
- project_id (bigint, foreign key) - Referencia a projects.id
```

## Proyectos de Ejemplo Creados

1. **BICM - Refinería Barrancabermeja** (C-19-001) - GECON
2. **Terminal Norte - Ampliación Muelles** (B-20-001) - GEBOC
3. **Modernización Refinería Cartagena** (M-21-003) - GEMAM
4. **Infraestructura Digital ECOPETROL** (D-22-005) - GEDIN
5. **Oleoducto Bicentenario - Fase II** (C-23-007) - GECON
6. **Terminal Coveñas - Optimización** (B-24-009) - GEBOC
7. **Planta Polietileno Barrancas** (M-25-011) - GEMAM

## Funcionalidades

- **Selector de Proyectos**: Dropdown que muestra nombre del proyecto y código SAP
- **Validación**: Verifica que el proyecto seleccionado existe en la base de datos
- **Visualización**: La tabla muestra el nombre del proyecto y código SAP en formato organizado
- **Edición**: Al editar una inspección, se preselecciona el proyecto correcto
- **Relaciones**: Las inspecciones mantienen una relación apropiada con los proyectos

## Comandos para Ejecutar

```bash
# Migrar cambios
php artisan migrate

# Seedar proyectos
php artisan db:seed --class=ProjectSeeder

# Verificar estructura
php artisan tinker
```

## Beneficios

1. **Consistencia**: Los nombres de proyectos son consistentes en toda la aplicación
2. **Trazabilidad**: Cada inspección está vinculada a un proyecto específico
3. **Reportes**: Facilita la generación de reportes por proyecto
4. **Mantenimiento**: Los datos de proyectos se mantienen centralizados
5. **Validación**: Previene errores de tipeo en nombres de proyectos
