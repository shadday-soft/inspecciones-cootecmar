<script setup>
import { ref, computed, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Card from 'primevue/card'
import Chart from 'primevue/chart'
import Calendar from 'primevue/calendar'
import Dialog from 'primevue/dialog'

// Props recibidas del controlador
const props = defineProps({
    kpis: Object,
    chartData: Object,
    calendarEvents: Array
})

// Estado reactivo
const selectedInspection = ref(null)
const selectedInspections = ref([]) // Para múltiples inspecciones
const showInspectionModal = ref(false)
const selectedDate = ref(new Date())
const currentInspectionIndex = ref(0) // Para navegar entre inspecciones

// Configuraciones de gráficas
const chartOptions = ref({
    pie: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        responsive: true,
        maintainAspectRatio: false
    },
    doughnut: {
        plugins: {
            legend: {
                position: 'bottom'
            }
        },
        responsive: true,
        maintainAspectRatio: false
    },
    bar: {
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    },
    line: {
        plugins: {
            legend: {
                display: false
            }
        },
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
})

// Eventos del calendario convertidos al formato FullCalendar
const calendarEventsFormatted = computed(() => {
    return props.calendarEvents.map(event => ({
        id: event.id,
        title: event.title,
        start: new Date(event.start),
        backgroundColor: event.color,
        borderColor: event.color,
        inspection: event.inspection
    }))
})

// Función para manejar clic en el calendario
const handleDateSelect = (value) => {
    // Crear fecha en formato YYYY-MM-DD sin problemas de zona horaria
    const year = value.getFullYear()
    const month = String(value.getMonth() + 1).padStart(2, '0')
    const day = String(value.getDate()).padStart(2, '0')
    const selectedDateStr = `${year}-${month}-${day}`
    
    // Buscar inspecciones en la fecha seleccionada
    const inspectionsOnDate = props.calendarEvents.filter(event => {
        return event.start === selectedDateStr
    })
    
    if (inspectionsOnDate.length > 0) {
        // Ordenar las inspecciones por prioridad
        const sortedInspections = inspectionsOnDate.sort((a, b) => {
            const getPriorityValue = (prioridad) => {
                if (prioridad === 'Alta' || prioridad === 1) return 1
                if (prioridad === 'Media' || prioridad === 2) return 2
                if (prioridad === 'Baja' || prioridad === 3) return 3
                return 4
            }
            
            // Priorizar programadas sobre no programadas
            if (a.type === 'programmed' && b.type === 'unprogrammed') return -1
            if (a.type === 'unprogrammed' && b.type === 'programmed') return 1
            
            return getPriorityValue(a.inspection.prioridad) - getPriorityValue(b.inspection.prioridad)
        })
        
        selectedInspections.value = sortedInspections.map(event => event.inspection)
        selectedInspection.value = sortedInspections[0].inspection
        currentInspectionIndex.value = 0
        showInspectionModal.value = true
    }
}

// Función para navegar entre inspecciones del mismo día
const nextInspection = () => {
    if (currentInspectionIndex.value < selectedInspections.value.length - 1) {
        currentInspectionIndex.value++
        selectedInspection.value = selectedInspections.value[currentInspectionIndex.value]
    }
}

const previousInspection = () => {
    if (currentInspectionIndex.value > 0) {
        currentInspectionIndex.value--
        selectedInspection.value = selectedInspections.value[currentInspectionIndex.value]
    }
}

// Función para obtener el número de inspecciones en una fecha
const getInspectionsCountForDate = (date) => {
    const inspectionsOnDate = props.calendarEvents.filter(event => {
        // Parseamos la fecha como fecha local para evitar problemas de zona horaria
        const eventDateParts = event.start.split('-')
        const eventYear = parseInt(eventDateParts[0])
        const eventMonth = parseInt(eventDateParts[1]) - 1 // JavaScript usa 0-11 para meses
        const eventDay = parseInt(eventDateParts[2])
        
        return eventDay === date.day && 
               eventMonth === date.month && 
               eventYear === date.year
    })
    return inspectionsOnDate.length
}

// Función para formatear fecha
const formatDate = (dateString) => {
    if (!dateString) return 'No especificada'
    return new Date(dateString).toLocaleDateString('es-ES', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
}

// Función para obtener el texto de prioridad
const getPriorityText = (priority) => {
    // Manejar tanto valores numéricos como de texto
    if (priority === 'Alta' || priority === 1) {
        return { text: 'Alta', class: 'bg-red-100 text-red-800' }
    } else if (priority === 'Media' || priority === 2) {
        return { text: 'Media', class: 'bg-yellow-100 text-yellow-800' }
    } else if (priority === 'Baja' || priority === 3) {
        return { text: 'Baja', class: 'bg-green-100 text-green-800' }
    } else {
        return { text: 'Sin especificar', class: 'bg-gray-100 text-gray-800' }
    }
}

// Configuración del calendario con eventos
const calendarDateTemplate = (date) => {
    // Buscar inspecciones en esta fecha específica
    const inspectionsOnDate = props.calendarEvents.filter(event => {
        // Parseamos la fecha como fecha local para evitar problemas de zona horaria
        const eventDateParts = event.start.split('-')
        const eventYear = parseInt(eventDateParts[0])
        const eventMonth = parseInt(eventDateParts[1]) - 1 // JavaScript usa 0-11 para meses
        const eventDay = parseInt(eventDateParts[2])
        
        return eventDay === date.day && 
               eventMonth === date.month && 
               eventYear === date.year
    })
    
    if (inspectionsOnDate.length === 0) {
        return {
            class: '',
            style: ''
        }
    }

    // Si hay múltiples inspecciones en el mismo día, usar la de mayor prioridad o tipo específico
    let dominantInspection = inspectionsOnDate[0]
    
    // Priorizar las programadas con prioridad alta, luego las no programadas
    const sortedInspections = inspectionsOnDate.sort((a, b) => {
        // Primero, separar por tipo
        if (a.type === 'programmed' && b.type === 'unprogrammed') return -1
        if (a.type === 'unprogrammed' && b.type === 'programmed') return 1
        
        // Si ambas son del mismo tipo, ordenar por prioridad
        const getPriorityValue = (prioridad) => {
            if (prioridad === 'Alta' || prioridad === 1) return 1
            if (prioridad === 'Media' || prioridad === 2) return 2
            if (prioridad === 'Baja' || prioridad === 3) return 3
            return 4
        }
        
        return getPriorityValue(a.inspection.prioridad) - getPriorityValue(b.inspection.prioridad)
    })
    
    dominantInspection = sortedInspections[0]
    
    // Determinar el color y estilo basado en el tipo y prioridad
    let bgClass = ''
    let textClass = ''
    
    if (dominantInspection.type === 'unprogrammed') {
        // Inspecciones no programadas - púrpura
        bgClass = 'bg-purple-100'
        textClass = 'text-purple-800'
    } else {
        // Inspecciones programadas - color según prioridad
        const prioridad = dominantInspection.inspection.prioridad
        if (prioridad === 'Alta' || prioridad === 1) {
            bgClass = 'bg-red-100'
            textClass = 'text-red-800'
        } else if (prioridad === 'Media' || prioridad === 2) {
            bgClass = 'bg-amber-100'
            textClass = 'text-amber-800'
        } else if (prioridad === 'Baja' || prioridad === 3) {
            bgClass = 'bg-green-100'
            textClass = 'text-green-800'
        } else {
            bgClass = 'bg-gray-100'
            textClass = 'text-gray-800'
        }
    }
    
    return {
        class: `${bgClass} ${textClass} font-semibold`,
        style: 'border-radius: 50%; cursor: pointer;',
        count: inspectionsOnDate.length // Agregar el conteo
    }
}

onMounted(() => {
    // Configuración adicional si es necesaria
})
</script>

<template>
    <AppLayout title="Dashboard de Inspecciones">
        <div class="p-6 space-y-6">
            <!-- Encabezado -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Dashboard y Calendario de Inspecciones
                </h1>
                <p class="text-gray-600 dark:text-gray-400 mt-2">
                    Vista general del sistema de inspecciones y programación
                </p>
            </div>

            <!-- Sección de KPIs -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <Card class="bg-gradient-to-r from-blue-500 to-blue-600 text-white">
                    <template #content>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-blue-800 text-sm font-medium">Total Inspecciones</p>
                                <p class="text-3xl font-bold">{{ kpis.totalInspections }}</p>
                            </div>
                            <div class="text-blue-200">
                                <i class="pi pi-list text-2xl"></i>
                            </div>
                        </div>
                    </template>
                </Card>

                <Card class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                    <template #content>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-green-800 text-sm font-medium">Completadas (30 días)</p>
                                <p class="text-3xl font-bold">{{ kpis.completedInspections30Days }}</p>
                            </div>
                            <div class="text-green-200">
                                <i class="pi pi-check-circle text-2xl"></i>
                            </div>
                        </div>
                    </template>
                </Card>

                <Card class="bg-gradient-to-r from-purple-500 to-purple-600 text-white">
                    <template #content>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-purple-800 text-sm font-medium">Inspectores Activos</p>
                                <p class="text-3xl font-bold">{{ kpis.activeInspectors }}</p>
                            </div>
                            <div class="text-purple-200">
                                <i class="pi pi-users text-2xl"></i>
                            </div>
                        </div>
                    </template>
                </Card>

                <Card class="bg-gradient-to-r from-orange-500 to-orange-600 text-white">
                    <template #content>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-orange-800 text-sm font-medium">Próximas (7 días)</p>
                                <p class="text-3xl font-bold">{{ kpis.upcomingInspections7Days }}</p>
                            </div>
                            <div class="text-orange-200">
                                <i class="pi pi-calendar text-2xl"></i>
                            </div>
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Sección de Gráficas -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Gráfica de Pastel - Inspecciones por Tipo -->
                <Card>
                    <template #title>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-chart-pie text-blue-500"></i>
                            <span class="text-lg font-semibold">Inspecciones por Tipo</span>
                        </div>
                    </template>
                    <template #content>
                        <div style="height: 300px;">
                            <Chart 
                                type="pie" 
                                :data="chartData.inspectionsByType" 
                                :options="chartOptions.pie"
                                class="h-full"
                            />
                        </div>
                    </template>
                </Card>

                <!-- Gráfica de Dona - Estado General -->
                <Card>
                    <template #title>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-chart-donut text-green-500"></i>
                            <span class="text-lg font-semibold">Estado General</span>
                        </div>
                    </template>
                    <template #content>
                        <div style="height: 300px;">
                            <Chart 
                                type="doughnut" 
                                :data="chartData.inspectionsByStatus" 
                                :options="chartOptions.doughnut"
                                class="h-full"
                            />
                        </div>
                    </template>
                </Card>

                <!-- Gráfica de Barras - Rendimiento de Inspectores -->
                <Card>
                    <template #title>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-chart-bar text-purple-500"></i>
                            <span class="text-lg font-semibold">Rendimiento de Inspectores</span>
                        </div>
                    </template>
                    <template #content>
                        <div style="height: 300px;">
                            <Chart 
                                type="bar" 
                                :data="chartData.inspectorPerformance" 
                                :options="chartOptions.bar"
                                class="h-full"
                            />
                        </div>
                    </template>
                </Card>

                <!-- Gráfica de Líneas - Inspecciones a lo largo del tiempo -->
                <Card>
                    <template #title>
                        <div class="flex items-center gap-2">
                            <i class="pi pi-chart-line text-orange-500"></i>
                            <span class="text-lg font-semibold">Tendencia Temporal</span>
                        </div>
                    </template>
                    <template #content>
                        <div style="height: 300px;">
                            <Chart 
                                type="line" 
                                :data="chartData.inspectionsOverTime" 
                                :options="chartOptions.line"
                                class="h-full"
                            />
                        </div>
                    </template>
                </Card>
            </div>

            <!-- Sección del Calendario -->
            <Card>
                <template #title>
                    <div class="flex items-center gap-2">
                        <i class="pi pi-calendar text-blue-500"></i>
                        <span class="text-xl font-semibold">Calendario de Inspecciones</span>
                    </div>
                </template>
                <template #content>
                    <div class="space-y-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <p class="text-sm text-blue-700 dark:text-blue-300 flex items-center gap-2">
                                <i class="pi pi-info-circle"></i>
                                Haz clic en una fecha resaltada para ver los detalles de la inspección programada
                            </p>
                        </div>
                        
                        <div class="flex justify-center">
                            <Calendar 
                                v-model="selectedDate"
                                inline
                                :showOtherMonths="false"
                                class="w-full max-w-lg calendar-with-badges"
                                @date-select="handleDateSelect"
                                style="overflow: visible;"
                            >
                                <template #date="{ date }">
                                    <div 
                                        :class="calendarDateTemplate(date).class"
                                        :style="calendarDateTemplate(date).style"
                                        class="w-8 h-8 flex flex-col items-center justify-center rounded-full relative text-center"
                                    >
                                        <span class="text-sm font-medium">{{ date.day }}</span>
                                        <!-- Mostrar conteo de inspecciones como texto pequeño -->
                                        <span 
                                            v-if="getInspectionsCountForDate(date) > 1"
                                            class="text-xs font-bold leading-none"
                                            style="font-size: 8px; margin-top: -2px;"
                                        >
                                            ({{ getInspectionsCountForDate(date) }})
                                        </span>
                                    </div>
                                </template>
                            </Calendar>
                        </div>

                        <!-- Leyenda del calendario -->
                        <div class="flex flex-wrap gap-4 justify-center mt-4">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                                <span class="text-sm">Programada - Prioridad Alta</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-amber-500 rounded-full"></div>
                                <span class="text-sm">Programada - Prioridad Media</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                                <span class="text-sm">Programada - Prioridad Baja</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 bg-purple-600 rounded-full"></div>
                                <span class="text-sm">Pendiente de Programación</span>
                            </div>
                        </div>
                    </div>
                </template>
            </Card>

            <!-- Modal de Detalles de Inspección -->
            <Dialog 
                v-model:visible="showInspectionModal" 
                modal 
                :header="selectedInspections.length > 1 ? 
                    `Inspecciones del día (${currentInspectionIndex + 1} de ${selectedInspections.length})` : 
                    'Detalles de la Inspección'"
                :style="{ width: '50rem' }"
                :maximizable="true"
                class="p-fluid"
            >
                <div v-if="selectedInspection" class="space-y-6">
                    <!-- Navegación entre inspecciones -->
                    <div v-if="selectedInspections.length > 1" class="flex justify-between items-center bg-gray-50 dark:bg-gray-800 p-3 rounded-lg">
                        <button 
                            @click="previousInspection"
                            :disabled="currentInspectionIndex === 0"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                            :class="currentInspectionIndex === 0 ? 
                                'text-gray-400 cursor-not-allowed' : 
                                'text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                        >
                            <i class="pi pi-chevron-left"></i>
                            Anterior
                        </button>
                        
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                Inspección {{ currentInspectionIndex + 1 }} de {{ selectedInspections.length }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Múltiples inspecciones programadas
                            </p>
                        </div>
                        
                        <button 
                            @click="nextInspection"
                            :disabled="currentInspectionIndex === selectedInspections.length - 1"
                            class="flex items-center gap-2 px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                            :class="currentInspectionIndex === selectedInspections.length - 1 ? 
                                'text-gray-400 cursor-not-allowed' : 
                                'text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/20'"
                        >
                            Siguiente
                            <i class="pi pi-chevron-right"></i>
                        </button>
                    </div>
                    <!-- Información Principal -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Código de Inspección</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ selectedInspection.code }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Proyecto</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.project_name }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tipo de Inspección</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.tipo || 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Gerencia</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.gerencia || 'No especificada' }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Inspector Asignado</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.inspector }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Solicitante</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.solicitante || 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Supervisor</label>
                                <p class="text-lg text-gray-900 dark:text-white">{{ selectedInspection.supervisor || 'No especificado' }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Estado</label>
                                <span 
                                    :class="selectedInspection.status === 'Programada' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800'"
                                    class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                                >
                                    {{ selectedInspection.status }}
                                </span>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Prioridad</label>
                                <span 
                                    :class="getPriorityText(selectedInspection.prioridad).class"
                                    class="inline-flex px-2 py-1 text-xs font-medium rounded-full"
                                >
                                    {{ getPriorityText(selectedInspection.prioridad).text }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Fecha y Hora -->
                    <div class="border-t pt-4">
                        <div v-if="selectedInspection.fecha_programada" class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha y Hora Programada</label>
                                <p class="text-xl font-semibold text-blue-600 dark:text-blue-400">
                                    {{ formatDate(selectedInspection.fecha_programada) }}
                                </p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha Original</label>
                                <p class="text-lg text-gray-700 dark:text-gray-300">
                                    {{ formatDate(selectedInspection.fecha) }}
                                </p>
                            </div>
                        </div>
                        <div v-else>
                            <div>
                                <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Fecha de Inspección</label>
                                <p class="text-xl font-semibold text-purple-600 dark:text-purple-400">
                                    {{ formatDate(selectedInspection.fecha) }}
                                </p>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    ⏳ Esta inspección aún no ha sido programada
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div v-if="selectedInspection.descripcion" class="border-t pt-4">
                        <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Descripción</label>
                        <p class="mt-2 text-gray-900 dark:text-white leading-relaxed">
                            {{ selectedInspection.descripcion }}
                        </p>
                    </div>
                </div>

                <template #footer>
                    <div class="flex justify-between items-center">
                        <!-- Información adicional para múltiples inspecciones -->
                        <div v-if="selectedInspections.length > 1" class="text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center gap-1">
                                <i class="pi pi-calendar text-blue-500"></i>
                                {{ selectedInspections.length }} inspecciones en esta fecha
                            </span>
                        </div>
                        <div v-else></div>
                        
                        <div class="flex gap-2">
                            <button 
                                @click="showInspectionModal = false"
                                class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-200"
                            >
                                Cerrar
                            </button>
                            <button 
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-200"
                            >
                                Ver Detalles Completos
                            </button>
                        </div>
                    </div>
                </template>
            </Dialog>
        </div>
    </AppLayout>
</template>

<style scoped>
.p-calendar .p-datepicker table td > span {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.p-calendar .p-datepicker table td.p-datepicker-other-month > span {
    color: #9ca3af;
}

/* Estilos base para fechas del calendario */
.p-calendar .p-datepicker table td > span {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.p-calendar .p-datepicker table td.p-datepicker-other-month > span {
    color: #9ca3af;
}

/* Mejoras visuales para las gráficas */
.p-card .p-card-content {
    padding: 0;
}

/* Estilos para el modo oscuro */
@media (prefers-color-scheme: dark) {
    .p-calendar .p-datepicker {
        background-color: #374151;
        border-color: #4b5563;
    }
    
    .p-calendar .p-datepicker table td > span {
        color: #e5e7eb;
    }
}

/* Estilos específicos para los badges del calendario */
.calendar-with-badges .p-calendar {
    overflow: visible !important;
}

.calendar-with-badges .p-calendar .p-datepicker {
    overflow: visible !important;
}

.calendar-with-badges .p-calendar .p-datepicker table {
    overflow: visible !important;
}

.calendar-with-badges .p-calendar .p-datepicker table td {
    overflow: visible !important;
    position: relative;
}

.calendar-with-badges .p-calendar .p-datepicker table tbody {
    overflow: visible !important;
}

/* Asegurar que las celdas del calendario tengan espacio para los badges */
.calendar-with-badges .p-calendar .p-datepicker table td {
    padding: 4px !important;
}

/* Estilo específico para que los badges sean más visibles */
.calendar-with-badges .p-calendar .p-datepicker table td > div > div {
    overflow: visible !important;
}
</style>
