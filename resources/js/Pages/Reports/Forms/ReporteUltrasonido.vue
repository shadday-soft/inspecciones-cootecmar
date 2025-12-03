<template>
    <div class="flex flex-col gap-y-6">
        <!-- Campos principales en grid -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <h4 class="flex items-center gap-2 text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4 pb-2 border-b border-gray-200 dark:border-gray-600">
                <i class="fa-solid fa-clipboard-list text-blue-600 dark:text-blue-400"></i>
                Información General
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div v-for="(input, index) of mainFields" :key="index">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">{{ input.textLabel }}</label>
                    <div class="rounded-lg border border-gray-300 dark:border-gray-600 focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent transition-all" :class="input.disabled ? 'bg-gray-100 dark:bg-gray-600' : 'bg-white dark:bg-gray-700'">
                        <input v-if="input.type == 'text'" type="text" v-model="input.value"
                            :disabled="input.disabled"
                            class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                        <input v-else-if="input.type == 'date'" type="date" v-model="input.value"
                            :disabled="input.disabled"
                            class="w-full px-3 py-2 border-0 rounded-lg focus:ring-0 bg-transparent dark:text-gray-200 disabled:cursor-not-allowed disabled:opacity-75" />
                    </div>
                </div>
            </div>
        </div>

        <!-- DATOS COMPONENTE -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-700 dark:to-indigo-800 p-4">
                <i class="fa-solid fa-cube text-white"></i>
                DATOS COMPONENTE (COMPONENT DATA)
            </h3>
            <div class="p-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ZONA INSPECCIONADA (INSPECTIONED ZONE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'zona_inspeccionada').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">DIMENSIONES (DIMENSIONS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'dimensiones').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ESPECIFICACIÓN DEL MATERIAL (MATERIAL ESPECIFICATION):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'especificacion_material').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ACABADO SUPERFICIAL (SURFACE FINISH):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'acabado_superficial').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ÁREA DE INSPECCIÓN (INSPECTION AREA):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'area_inspeccion').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TEMPERATURA (TEMPERATURE):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PROCESO DE FABRICACIÓN (FABRICATION PROCESS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'proceso_fabricacion').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ESPESOR DEL MATERIAL (MATERIAL THICKNESS):</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'espesor_material').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                </div>
            </div>
        </div>

        <!-- CONDICIONES DE INSPECCIÓN -->
        <div class="bg-gradient-to-br from-cyan-50 to-blue-50 dark:from-gray-800 dark:to-gray-700 border-2 border-cyan-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <h3 class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-gray-100 mb-5 pb-3 border-b-2 border-cyan-300 dark:border-gray-600">
                <i class="fa-solid fa-wave-square text-cyan-600 dark:text-cyan-400"></i>
                CONDICIONES DE INSPECCIÓN (INSPECTION CONDITION)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TIPO DE REPRESENTACIÓN (REPRESENTATION TYPE):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'tipo_representacion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">MÉTODO DE INSPECCIÓN (INSPECTION METHOD):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'metodo_inspeccion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TÉCNICA USADA (TECHNIQUE):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'tecnica_usada').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ACOPLANTE (COUPLANT):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'acoplante').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PROCEDIMIENTO (PROCEDURE):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'procedimiento').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">BLOQUE DE CALIBRACIÓN (CALIBRATION BLOCK):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'bloque_calibracion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">EQUIPO (EQUIPMENT):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'equipo').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">FRECUENCIA (FREQUENCY):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'frecuencia').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">PALPADOR (UNIT SEARCH):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'palpador').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">MÉTODO DE CALIBRACIÓN (CALIBRATION METHOD):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'metodo_calibracion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">ÁNGULO (ANGLE):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'angulo').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CRITERIOS DE ACEPTACIÓN (ACCEPTANCE LEVEL):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'criterios_aceptacion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CÓDIGO METROLÓGICO (METROLOGICAL CODE):</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'codigo_metrologico').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">FECHA DE CALIBRACIÓN (CALIBRATION DATE):</label>
                    <input type="date" v-model="form.inputs.find(i => i.label === 'fecha_calibracion').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                </div>
            </div>
        </div>

        <!-- ESQUEMAS (SKETCHS) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-diagram-project text-purple-600 dark:text-purple-400"></i>
                ESQUEMAS (SKETCHS)
            </label>
            <div class="rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-4 bg-gray-50 dark:bg-gray-700 hover:border-purple-400 dark:hover:border-purple-500 transition-colors">
                <input 
                    type="file" 
                    @change="handleEsquemasUpload"
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-purple-500 cursor-pointer bg-white dark:bg-gray-600 dark:text-gray-200"
                />
                <div v-if="esquemasImagen" class="mt-4">
                    <p class="flex items-center gap-2 text-green-600 dark:text-green-400 font-semibold mb-3">
                        <i class="fa-solid fa-check-circle"></i>
                        Imagen cargada correctamente
                    </p>
                    <img :src="esquemasImagen" alt="Esquemas" class="border-2 border-gray-300 dark:border-gray-600 rounded-lg max-w-full h-auto shadow-md" style="max-height: 400px;" />
                    <button 
                        @click="removeEsquemasImage" 
                        type="button"
                        class="mt-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2"
                    >
                        <i class="fa-solid fa-trash"></i>
                        Eliminar imagen
                    </button>
                </div>
            </div>
        </div>

        <!-- Tabla de Descripción del Defecto -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-red-600 to-red-700 dark:from-red-700 dark:to-red-800 p-4">
                <i class="fa-solid fa-exclamation-triangle text-white"></i>
                DESCRIPCIÓN DEL DEFECTO (FLAW CHARACTERIZATION)
            </h3>
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-xs">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-700">
                            <th class="border-r border-gray-300 dark:border-gray-600 p-2 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 5%;">No.<br>ITEM</th>
                            <th class="border-r border-gray-300 dark:border-gray-600 p-2 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 8%;">ÁNGULO<br>INDICACIÓN<br>(ANGLE)</th>
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 8%;">ANCHO CARA<br>DIÁMETRO<br>(FACE WIDTH)<br>mm</th>
                            <th class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 8%;">PIERNA<br>PIES<br>(FEET LEG)<br>mm</th>
                            <th colspan="4" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 16%;">DECIBELES (INCHES) dB<br>(AWS)</th>
                            <th colspan="3" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 18%;">INDICACIÓN<br>(INVOCATION)</th>
                            <th colspan="2" class="border-r-2 border-gray-800 p-2 text-center font-bold" style="width: 12%;">DISTANCIA<br>(LOCATION)</th>
                            <th class="p-2 text-center font-bold" style="width: 25%;">COMENTARIOS<br>(COMMENTARIES)</th>
                        </tr>
                        <tr class="bg-gray-100 border-b border-gray-800">
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r-2 border-gray-800 p-1"></th>
                            <th class="border-r border-gray-800 p-1 text-center">a</th>
                            <th class="border-r border-gray-800 p-1 text-center">b</th>
                            <th class="border-r border-gray-800 p-1 text-center">c</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">d</th>
                            <th class="border-r border-gray-800 p-1 text-center">PA<br>mm</th>
                            <th class="border-r border-gray-800 p-1 text-center">SA<br>mm</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">DA<br>mm</th>
                            <th class="border-r border-gray-800 p-1 text-center">X<br>(mm)</th>
                            <th class="border-r-2 border-gray-800 p-1 text-center">Y</th>
                            <th class="p-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="n in 10" :key="n" class="border-b border-gray-800">
                            <td class="border-r-2 border-gray-800 p-1 text-center font-bold">{{ n }}</td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].angulo_indicacion"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].ancho_cara"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].pierna_pies"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_a"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_b"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_c"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].decibeles_d"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_pa"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_sa"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].indicacion_da"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].distancia_x"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="border-r-2 border-gray-800 p-1">
                                <input type="text" v-model="defectos[n-1].distancia_y"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                            <td class="p-1">
                                <input type="text" v-model="defectos[n-1].comentarios"
                                    class="w-full px-1 py-1 border-0 text-xs focus:ring-1 focus:ring-blue-500" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Observaciones -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-comment-dots text-blue-600 dark:text-blue-400"></i>
                OBSERVACIONES (OBSERVATIONS)
            </label>
            <div class="rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
                <QuillEditor theme="snow" v-model:content="form.inputs.find(i => i.label === 'observaciones').value" contentType="html" toolbar="full" />
            </div>
        </div>

        <!-- Convenciones -->
        <div class="bg-amber-50 dark:bg-gray-800 border-2 border-amber-300 dark:border-gray-600 rounded-lg p-4 shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <i class="fa-solid fa-info-circle text-amber-600 dark:text-amber-400"></i>
                <strong class="text-gray-800 dark:text-gray-200">Convenciones (Conventions):</strong>
            </div>
            <div class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
                <p><strong>SA:</strong> Distancia De Recorrido Del Sonido (Sweep Distance); <strong>PA:</strong> Longitud Horizontal (Horizontal Position) (RA);</p>
                <p><strong>DA:</strong> Profundidad (Depth Position);</p>
                <p><strong>a:</strong> Indication Level; <strong>b:</strong> Reference Level; <strong>c:</strong> Attenuation Factor; <strong>d:</strong> Indication Rating</p>
            </div>
        </div>

        <!-- Resultado Final -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 border-2 border-green-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <label class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100 mb-4">
                <i class="fa-solid fa-clipboard-check text-green-600 dark:text-green-400"></i>
                FINAL TEST RESULT
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-3 cursor-pointer px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-400 transition-all bg-white dark:bg-gray-700">
                    <input type="radio" value="ACEPTADO (ACCEPTED)" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5 text-green-600" />
                    <span class="font-semibold text-gray-700 dark:text-gray-300">■ ACEPTADO (ACCEPTED)</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-400 transition-all bg-white dark:bg-gray-700">
                    <input type="radio" value="RECHAZADO (NON ACCEPTED)" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5 text-red-600" />
                    <span class="font-semibold text-gray-700 dark:text-gray-300">□ RECHAZADO (NON ACCEPTED)</span>
                </label>
            </div>
        </div>

        <!-- Sección de Firmas -->
        <SignatureSection 
            v-model:elaborado-por-nombre="elaboradoPorNombre"
            v-model:elaborado-por-cargo="elaboradoPorCargo"
            v-model:elaborado-por-firma="elaboradoPorFirma"
            v-model:revisado-por-nombre="revisadoPorNombre"
            v-model:revisado-por-cargo="revisadoPorCargo"
            v-model:revisado-por-firma="revisadoPorFirma"
        />

    <!-- Botones de acción -->
    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-600">
        <Button 
            @click="submit" 
            label="Guardar Reporte" 
            severity="success" 
            size="small" 
            icon="fa-solid fa-save"
            :loading="form.processing"
            :disabled="form.processing"
            class="shadow-sm hover:shadow-md transition-shadow"
        />
        <Button 
            label="Cancelar" 
            severity="danger" 
            size="small" 
            icon="fa-solid fa-xmark"
            :disabled="form.processing"
            @click="$emit('cancel')"
            class="shadow-sm hover:shadow-md transition-shadow"
        />
    </div>
</template>

<script setup>
import { useForm, usePage, router } from "@inertiajs/vue3";
import { watch, ref, computed } from "vue";
import SignatureSection from "@/Components/Customs/SignatureSection.vue";
import Button from "primevue/button";
import { QuillEditor } from '@vueup/vue-quill';
import '@vueup/vue-quill/dist/vue-quill.snow.css';
import Swal from "sweetalert2";

const props = defineProps({
    inspeccion: Object,
    users: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['cancel']);

// Variables reactivas
const elaboradoPorNombre = ref('');
const elaboradoPorCargo = ref('');
const elaboradoPorFirma = ref(null);
const revisadoPorNombre = ref('');
const revisadoPorCargo = ref('');
const revisadoPorFirma = ref(null);
const esquemasImagen = ref(null);

// Array para defectos (10 filas)
const defectos = ref(Array.from({ length: 10 }, () => ({
    angulo_indicacion: '',
    ancho_cara: '',
    pierna_pies: '',
    decibeles_a: '',
    decibeles_b: '',
    decibeles_c: '',
    decibeles_d: '',
    indicacion_pa: '',
    indicacion_sa: '',
    indicacion_da: '',
    distancia_x: '',
    distancia_y: '',
    comentarios: ''
})));

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR ULTRASONIDO",
    inputs: [
        // Campos principales
        { label: "reporte_no", type: "text", textLabel: "REPORTE (REPORT) No.", value: props.inspeccion.code || "", disabled: true },
        { label: "fecha", type: "date", textLabel: "FECHA (DATE)", value: props.inspeccion.fecha || "", disabled: true },
        { label: "go_no", type: "text", textLabel: "G.O. No", value: "" },
        { label: "cliente", type: "text", textLabel: "CLIENTE (CUSTOMER)", value: "" },
        { label: "proyecto", type: "text", textLabel: "PROYECTO (PROJECT)", value: props.inspeccion.project?.name || "", disabled: true },
        { label: "lugar_inspeccion", type: "text", textLabel: "LUGAR DE INSPECCIÓN (INSPECTION PLACE)", value: "" },
        { label: "gerencia", type: "text", textLabel: "GERENCIA (MANAGEMENT)", value: props.inspeccion.gerencia || "", disabled: true },
        { label: "especificacion", type: "text", textLabel: "ESPECIFICACIÓN (STANDARD)", value: "" },
        { label: "pieza", type: "text", textLabel: "PIEZA (PIECE)", value: "" },
        
        // Datos Componente
        { label: "zona_inspeccionada", type: "text", textLabel: "ZONA INSPECCIONADA", value: "" },
        { label: "dimensiones", type: "text", textLabel: "DIMENSIONES", value: "" },
        { label: "especificacion_material", type: "text", textLabel: "ESPECIFICACIÓN DEL MATERIAL", value: "" },
        { label: "acabado_superficial", type: "text", textLabel: "ACABADO SUPERFICIAL", value: "" },
        { label: "area_inspeccion", type: "text", textLabel: "ÁREA DE INSPECCIÓN", value: "" },
        { label: "temperatura", type: "text", textLabel: "TEMPERATURA", value: "" },
        { label: "proceso_fabricacion", type: "text", textLabel: "PROCESO DE FABRICACIÓN", value: "" },
        { label: "espesor_material", type: "text", textLabel: "ESPESOR DEL MATERIAL", value: "" },
        
        // Condiciones de Inspección
        { label: "tipo_representacion", type: "text", textLabel: "TIPO DE REPRESENTACIÓN", value: "" },
        { label: "metodo_inspeccion", type: "text", textLabel: "MÉTODO DE INSPECCIÓN", value: "" },
        { label: "tecnica_usada", type: "text", textLabel: "TÉCNICA USADA", value: "" },
        { label: "acoplante", type: "text", textLabel: "ACOPLANTE", value: "" },
        { label: "procedimiento", type: "text", textLabel: "PROCEDIMIENTO", value: "" },
        { label: "bloque_calibracion", type: "text", textLabel: "BLOQUE DE CALIBRACIÓN", value: "" },
        { label: "equipo", type: "text", textLabel: "EQUIPO", value: "" },
        { label: "frecuencia", type: "text", textLabel: "FRECUENCIA", value: "" },
        { label: "palpador", type: "text", textLabel: "PALPADOR", value: "" },
        { label: "metodo_calibracion", type: "text", textLabel: "MÉTODO DE CALIBRACIÓN", value: "" },
        { label: "angulo", type: "text", textLabel: "ÁNGULO", value: "" },
        { label: "criterios_aceptacion", type: "text", textLabel: "CRITERIOS DE ACEPTACIÓN", value: "" },
        { label: "codigo_metrologico", type: "text", textLabel: "CÓDIGO METROLÓGICO", value: "" },
        { label: "fecha_calibracion", type: "date", textLabel: "FECHA DE CALIBRACIÓN", value: "" },
        
        // Otros campos
        { label: "esquemas", type: "textLong", textLabel: "ESQUEMAS", value: "" },
        { label: "observaciones", type: "textLong", textLabel: "OBSERVACIONES", value: "" },
        { label: "resultado_final", type: "select", textLabel: "RESULTADO FINAL", value: "" }
    ],
});

// Campos principales (solo los primeros 9)
const mainFields = computed(() => {
    return form.inputs.filter(i => 
        ['reporte_no', 'fecha', 'go_no', 'cliente', 'proyecto', 'lugar_inspeccion', 'gerencia', 'especificacion', 'pieza'].includes(i.label)
    );
});

function handleEsquemasUpload(event) {
    const file = event.target.files[0];
    if (file) {
        if (!file.type.startsWith('image/')) {
            Swal.fire({
                title: "Archivo inválido",
                text: "Por favor selecciona un archivo de imagen válido.",
                icon: "error",
            });
            return;
        }

        if (file.size > 5 * 1024 * 1024) {
            Swal.fire({
                title: "Archivo muy grande",
                text: "La imagen no debe superar los 5MB.",
                icon: "error",
            });
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            esquemasImagen.value = e.target.result;
            const esquemasInput = form.inputs.find(i => i.label === 'esquemas');
            if (esquemasInput) {
                esquemasInput.value = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeEsquemasImage() {
    esquemasImagen.value = null;
    const esquemasInput = form.inputs.find(i => i.label === 'esquemas');
    if (esquemasInput) {
        esquemasInput.value = '';
    }
}

function submit() {
    if (!elaboradoPorNombre.value || !elaboradoPorCargo.value || !elaboradoPorFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa los datos de 'Elaborado Por'.",
            icon: "warning",
        });
        return;
    }

    if (!revisadoPorNombre.value || !revisadoPorCargo.value || !revisadoPorFirma.value) {
        Swal.fire({
            title: "Campos incompletos",
            text: "Por favor completa los datos de 'Revisado y Autorizado Por'.",
            icon: "warning",
        });
        return;
    }

    // Agregar defectos como JSON
    form.inputs.push({
        label: "defectos",
        textLabel: "DEFECTOS",
        value: JSON.stringify(defectos.value)
    });

    // Agregar datos de firmas
    form.inputs.push(
        {
            label: "elaborado_por_nombre",
            textLabel: "ELABORADO POR - NOMBRE",
            value: elaboradoPorNombre.value,
        },
        {
            label: "elaborado_por_cargo",
            textLabel: "ELABORADO POR - CARGO",
            value: elaboradoPorCargo.value,
        },
        {
            label: "elaborado_por_firma",
            textLabel: "ELABORADO POR - FIRMA",
            value: elaboradoPorFirma.value,
        },
        {
            label: "revisado_por_nombre",
            textLabel: "REVISADO POR - NOMBRE",
            value: revisadoPorNombre.value,
        },
        {
            label: "revisado_por_cargo",
            textLabel: "REVISADO POR - CARGO",
            value: revisadoPorCargo.value,
        },
        {
            label: "revisado_por_firma",
            textLabel: "REVISADO POR - FIRMA",
            value: revisadoPorFirma.value,
        }
    );
    
    form.post(route("reports.store"), {
        onSuccess: () => {
            Swal.fire({
                title: "¡Guardado!",
                text: "El reporte se ha creado correctamente.",
                icon: "success",
                timer: 2000,
                showConfirmButton: false,
            });
            emit('cancel');
        },
        onError: (errors) => {
            Swal.fire({
                title: "Error",
                text: "No se pudo guardar el reporte. Inténtalo de nuevo.",
                icon: "error",
            });
        },
    });
}
</script>
