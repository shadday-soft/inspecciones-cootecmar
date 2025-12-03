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

        <!-- Tabla de Especificación de los Materiales -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-purple-600 to-purple-700 dark:from-purple-700 dark:to-purple-800 p-4">
                <i class="fa-solid fa-flask text-white"></i>
                ESPECIFICACIÓN DE LOS MATERIALES
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">TIPO DE MATERIALES</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">APL.</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">FABRICANTE</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">REF. COMERCIAL</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300 w-1/5">LOTE No</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300">LIMPIADOR</td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'limpiador_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                    </tr>
                    <tr class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300">PARTÍCULAS MAGNÉTICAS</td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'particulas_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 font-semibold text-gray-700 dark:text-gray-300">PINTURA DE CONTRASTE</td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_apl').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_fabricante').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_ref_comercial').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="p-2">
                            <input type="text" v-model="form.inputs.find(i => i.label === 'pintura_lote').value"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-blue-500 bg-transparent dark:text-gray-200" />
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Condiciones en la Inspección -->
        <div class="bg-gradient-to-br from-teal-50 to-cyan-50 dark:from-gray-800 dark:to-gray-700 border-2 border-teal-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <h3 class="flex items-center gap-2 text-xl font-bold text-gray-800 dark:text-gray-100 mb-5 pb-3 border-b-2 border-teal-300 dark:border-gray-600">
                <i class="fa-solid fa-microscope text-teal-600 dark:text-teal-400"></i>
                CONDICIONES EN LA INSPECCIÓN
            </h3>
            
            <!-- 1. TÉCNICA DE MAGNETIZACIÓN -->
            <div class="mb-6 pb-6 border-b border-teal-200 dark:border-gray-600">
                <h4 class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100 mb-4">
                    <i class="fa-solid fa-magnet text-teal-600 dark:text-teal-400"></i>
                    1. TÉCNICA DE MAGNETIZACIÓN
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TIPO DE EQUIPO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'tipo_equipo').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">MARCA:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'marca_equipo').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">MODELO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'modelo_equipo').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CÓD. METROLÓGICO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'cod_metrologico_equipo').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">FECHA DE CALIBRACIÓN:</label>
                        <input type="date" v-model="form.inputs.find(i => i.label === 'fecha_calibracion_equipo').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                </div>
                
                <div class="mt-4">
                    <CheckboxMultiple
                        label="TIPO DE MAGNETIZACIÓN:"
                        :options="['LONGITUDINAL', 'CIRCUNFERENCIAL', 'MULTIDIRECCIONAL']"
                        v-model="form.inputs.find(i => i.label === 'tipo_magnetizacion').value"
                        icon="fa-solid fa-magnet"
                    />
                </div>

                <div class="mt-4">
                    <CheckboxMultiple
                        label="TIPO DE CORRIENTE:"
                        :options="['CC', 'CA']"
                        v-model="form.inputs.find(i => i.label === 'tipo_corriente').value"
                        icon="fa-solid fa-bolt"
                    />
                </div>

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">AMPERAJE:</label>
                    <input type="text" v-model="form.inputs.find(i => i.label === 'amperaje').value"
                        class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" 
                        placeholder="N/A" />
                </div>
            </div>

            <!-- 2. ESPECIFICACIONES GENERALES -->
            <div class="mb-6 pb-6 border-b border-teal-200 dark:border-gray-600">
                <h4 class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100 mb-4">
                    <i class="fa-solid fa-cogs text-teal-600 dark:text-teal-400"></i>
                    2. ESPECIFICACIONES GENERALES
                </h4>
                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div class="mb-3">
                    <CheckboxMultiple
                        label="CLASE DE PARTÍCULA MAGNÉTICA:"
                        :options="['P. M. SECAS', 'P. M. HÚMEDAS']"
                        v-model="form.inputs.find(i => i.label === 'clase_particula').value"
                        icon="fa-solid fa-vial"
                    />
                </div>

                <div class="mb-3">
                    <CheckboxMultiple
                        label="TIPO DE PARTÍCULAS:"
                        :options="['FLUORESCENTES', 'CONTRASTANTES', 'COLOR']"
                        v-model="form.inputs.find(i => i.label === 'tipo_particulas').value"
                        icon="fa-solid fa-circle-dot"
                    />
                </div>

                <div class="mb-3">
                    <CheckboxMultiple
                        label="SECUENCIA DE APLICACIÓN DE LAS PARTÍCULAS MAGNÉTICAS:"
                        :options="['CONTINUA', 'RESIDUAL']"
                        v-model="form.inputs.find(i => i.label === 'secuencia_aplicacion').value"
                        icon="fa-solid fa-arrow-right-arrow-left"
                    />
                </div>

                <div class="mb-3">
                    <CheckboxMultiple
                        label="MODO DE APLICACIÓN:"
                        :options="['VÍA SECA', 'VÍA HÚMEDA']"
                        v-model="form.inputs.find(i => i.label === 'modo_aplicacion').value"
                        icon="fa-solid fa-hand-sparkles"
                    />
                </div>

                <div class="mb-3">
                    <CheckboxMultiple
                        label="TIPO DE ILUMINACIÓN:"
                        :options="['NATURAL', 'BLANCA ARTIFICIAL', 'ULTRAVIOLETA']"
                        v-model="form.inputs.find(i => i.label === 'tipo_iluminacion').value"
                        icon="fa-solid fa-lightbulb"
                    />
                </div>
                </div>
                

                <div class="mb-3">
                    <label class="font-semibold block mb-2">DESMAGNETIZACIÓN:</label>
                    <div class="flex gap-8">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="SÍ" v-model="form.inputs.find(i => i.label === 'desmagnetizacion').value"
                                class="w-5 h-5" />
                            <span>SÍ</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" value="NO" v-model="form.inputs.find(i => i.label === 'desmagnetizacion').value"
                                class="w-5 h-5" />
                            <span>NO</span>
                        </label>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CAMPO RESIDUAL FINAL:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'campo_residual_final').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">TEMPERATURA DE SUPERFICIE:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'temperatura_superficie').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">CONCENTRACIÓN DEL BAÑO:</label>
                        <input type="text" v-model="form.inputs.find(i => i.label === 'concentracion_bano').value"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-transparent bg-white dark:bg-gray-700 dark:text-gray-200 transition-all" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabla de Discontinuidades (Croquis) -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 shadow-sm overflow-hidden">
            <h3 class="flex items-center gap-2 text-lg font-semibold text-white bg-gradient-to-r from-orange-600 to-orange-700 dark:from-orange-700 dark:to-orange-800 p-4">
                <i class="fa-solid fa-chart-line text-white"></i>
                3. CROQUIS (Ver detalle en la Pág. 2)
            </h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 5%;">ITEM</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 35%;">DESCRIPCIÓN DE LA DISCONTINUIDAD</th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 15%;">FORMA<br><small>(LINEAL/REDONDA)</small></th>
                        <th class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 20%;">DIMENSIÓN</th>
                        <th class="p-3 text-center font-semibold text-gray-700 dark:text-gray-300" style="width: 25%;">EVALUACIÓN<br><small>(ACEPTADA/RECHAZADA)</small></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="n in 6" :key="n" class="border-b border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="border-r border-gray-300 dark:border-gray-600 p-3 text-center font-semibold text-gray-700 dark:text-gray-300">{{ n }}</td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="discontinuidades[n-1].descripcion"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-orange-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <select v-model="discontinuidades[n-1].forma"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-orange-500 bg-transparent dark:text-gray-200">
                                <option value="">-</option>
                                <option value="LINEAL">LINEAL</option>
                                <option value="REDONDA">REDONDA</option>
                            </select>
                        </td>
                        <td class="border-r border-gray-300 dark:border-gray-600 p-2">
                            <input type="text" v-model="discontinuidades[n-1].dimension"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-orange-500 bg-transparent dark:text-gray-200" />
                        </td>
                        <td class="p-2">
                            <select v-model="discontinuidades[n-1].evaluacion"
                                class="w-full px-2 py-1 border-0 focus:ring-1 focus:ring-orange-500 bg-transparent dark:text-gray-200">
                                <option value="">-</option>
                                <option value="ACEPTADA">ACEPTADA</option>
                                <option value="RECHAZADA">RECHAZADA</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Detalle de la Pieza -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-image text-indigo-600 dark:text-indigo-400"></i>
                DETALLE DE LA PIEZA
            </label>
            <div class="rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-600 p-4 bg-gray-50 dark:bg-gray-700 hover:border-indigo-400 dark:hover:border-indigo-500 transition-colors">
                <input 
                    type="file" 
                    @change="handleImageUpload"
                    accept="image/*"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-indigo-500 cursor-pointer bg-white dark:bg-gray-600 dark:text-gray-200"
                />
                <div v-if="detallePiezaImagen" class="mt-4">
                    <p class="flex items-center gap-2 text-green-600 dark:text-green-400 font-semibold mb-3">
                        <i class="fa-solid fa-check-circle"></i>
                        Imagen cargada correctamente
                    </p>
                    <img :src="detallePiezaImagen" alt="Detalle de la pieza" class="border-2 border-gray-300 dark:border-gray-600 rounded-lg max-w-full h-auto shadow-md" style="max-height: 400px;" />
                    <button 
                        @click="removeImage" 
                        type="button"
                        class="mt-3 px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors shadow-sm flex items-center gap-2"
                    >
                        <i class="fa-solid fa-trash"></i>
                        Eliminar imagen
                    </button>
                </div>
            </div>
        </div>

        <!-- Observaciones -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-5 shadow-sm">
            <label class="flex items-center gap-2 text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                <i class="fa-solid fa-comment-dots text-blue-600 dark:text-blue-400"></i>
                OBSERVACIONES
            </label>
            <div class="rounded-lg border border-gray-300 dark:border-gray-600 overflow-hidden">
                <QuillEditor theme="snow" v-model:content="form.inputs.find(i => i.label === 'observaciones').value" contentType="html" toolbar="full" />
            </div>
        </div>

        <!-- Resultado Final -->
        <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-gray-800 dark:to-gray-700 border-2 border-green-300 dark:border-gray-600 rounded-xl p-6 shadow-md">
            <label class="flex items-center gap-2 font-bold text-lg text-gray-800 dark:text-gray-100 mb-4">
                <i class="fa-solid fa-clipboard-check text-green-600 dark:text-green-400"></i>
                RESULTADO FINAL DE LA PRUEBA
            </label>
            <div class="flex gap-6">
                <label class="flex items-center gap-3 cursor-pointer px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-green-500 dark:hover:border-green-400 transition-all bg-white dark:bg-gray-700">
                    <input type="radio" value="SATISFACTORIA" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5 text-green-600" />
                    <span class="font-semibold text-gray-700 dark:text-gray-300">SATISFACTORIA</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer px-4 py-3 rounded-lg border-2 border-gray-300 dark:border-gray-600 hover:border-red-500 dark:hover:border-red-400 transition-all bg-white dark:bg-gray-700">
                    <input type="radio" value="NO SATISFACTORIA" v-model="form.inputs.find(i => i.label === 'resultado_final').value"
                        class="w-5 h-5 text-red-600" />
                    <span class="font-semibold text-gray-700 dark:text-gray-300">NO SATISFACTORIA</span>
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
    </div>

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
import CheckboxMultiple from "@/Components/Customs/CheckboxMultiple.vue";
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
const detallePiezaImagen = ref(null);

// Array para discontinuidades (6 items)
const discontinuidades = ref(Array.from({ length: 6 }, () => ({
    descripcion: '',
    forma: '',
    dimension: '',
    evaluacion: ''
})));

const form = useForm({
    inspection_id: props.inspeccion.id,
    type: "REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS",
    inputs: [
        // Campos principales
        { label: "informe_no", type: "text", textLabel: "INFORME No.", value: props.inspeccion.code || "", disabled: true },
        { label: "fecha", type: "date", textLabel: "FECHA", value: props.inspeccion.fecha || "", disabled: true },
        { label: "go_no", type: "text", textLabel: "G.O. No.", value: "" },
        { label: "cliente", type: "text", textLabel: "CLIENTE", value: "" },
        { label: "proyecto", type: "text", textLabel: "PROYECTO", value: props.inspeccion.project?.name || "", disabled: true },
        { label: "sitio_inspeccion", type: "text", textLabel: "SITIO DE INSPECCIÓN", value: "" },
        { label: "ciudad", type: "text", textLabel: "CIUDAD", value: "" },
        { label: "especificacion", type: "text", textLabel: "ESPECIFICACIÓN (NORMA)", value: "" },
        { label: "gerencia", type: "text", textLabel: "GERENCIA", value: props.inspeccion.gerencia || "", disabled: true },
        { label: "pieza_inspeccionar", type: "text", textLabel: "PIEZA A INSPECCIONAR", value: "" },
        { label: "material", type: "text", textLabel: "MATERIAL", value: "" },
        { label: "dimensiones", type: "text", textLabel: "DIMENSIONES", value: "" },
        { label: "area_inspeccionada", type: "text", textLabel: "ÁREA INSPECCIONADA", value: "" },
        { label: "acabado_superficial", type: "text", textLabel: "ACABADO SUPERFICIAL", value: "" },
        { label: "temperatura_pieza", type: "text", textLabel: "TEMPERATURA DE LA PIEZA", value: "" },
        { label: "humedad_relativa", type: "text", textLabel: "HUMEDAD RELATIVA", value: "" },
        { label: "instrumento_medicion", type: "text", textLabel: "INSTRUMENTO DE MEDICIÓN", value: "" },
        { label: "cod_metrologico", type: "text", textLabel: "CÓD. METROLÓGICO", value: "" },
        { label: "fecha_calibracion", type: "date", textLabel: "FECHA DE CALIBRACIÓN", value: "" },
        
        // Materiales
        { label: "limpiador_apl", type: "text", textLabel: "LIMPIADOR - APL.", value: "" },
        { label: "limpiador_fabricante", type: "text", textLabel: "LIMPIADOR - FABRICANTE", value: "" },
        { label: "limpiador_ref_comercial", type: "text", textLabel: "LIMPIADOR - REF. COMERCIAL", value: "" },
        { label: "limpiador_lote", type: "text", textLabel: "LIMPIADOR - LOTE", value: "" },
        { label: "particulas_apl", type: "text", textLabel: "PARTÍCULAS - APL.", value: "" },
        { label: "particulas_fabricante", type: "text", textLabel: "PARTÍCULAS - FABRICANTE", value: "" },
        { label: "particulas_ref_comercial", type: "text", textLabel: "PARTÍCULAS - REF. COMERCIAL", value: "" },
        { label: "particulas_lote", type: "text", textLabel: "PARTÍCULAS - LOTE", value: "" },
        { label: "pintura_apl", type: "text", textLabel: "PINTURA - APL.", value: "" },
        { label: "pintura_fabricante", type: "text", textLabel: "PINTURA - FABRICANTE", value: "" },
        { label: "pintura_ref_comercial", type: "text", textLabel: "PINTURA - REF. COMERCIAL", value: "" },
        { label: "pintura_lote", type: "text", textLabel: "PINTURA - LOTE", value: "" },
        
        // Técnica de Magnetización
        { label: "tipo_equipo", type: "text", textLabel: "TIPO DE EQUIPO", value: "" },
        { label: "marca_equipo", type: "text", textLabel: "MARCA", value: "" },
        { label: "modelo_equipo", type: "text", textLabel: "MODELO", value: "" },
        { label: "cod_metrologico_equipo", type: "text", textLabel: "CÓD. METROLÓGICO EQUIPO", value: "" },
        { label: "fecha_calibracion_equipo", type: "date", textLabel: "FECHA CALIBRACIÓN EQUIPO", value: "" },
        { label: "tipo_magnetizacion", type: "multiselect", textLabel: "TIPO DE MAGNETIZACIÓN", value: [], options: ["LONGITUDINAL", "CIRCUNFERENCIAL", "MULTIDIRECCIONAL"] },
        { label: "tipo_corriente", type: "multiselect", textLabel: "TIPO DE CORRIENTE", value: [], options: ["CC", "CA"] },
        { label: "amperaje", type: "text", textLabel: "AMPERAJE", value: "" },
        
        // Especificaciones Generales
        { label: "clase_particula", type: "multiselect", textLabel: "CLASE DE PARTÍCULA", value: [], options: ["P. M. SECAS", "P. M. HÚMEDAS"] },
        { label: "tipo_particulas", type: "multiselect", textLabel: "TIPO DE PARTÍCULAS", value: [], options: ["FLUORESCENTES", "CONTRASTANTES", "COLOR"] },
        { label: "secuencia_aplicacion", type: "multiselect", textLabel: "SECUENCIA DE APLICACIÓN", value: [], options: ["CONTINUA", "RESIDUAL"] },
        { label: "modo_aplicacion", type: "multiselect", textLabel: "MODO DE APLICACIÓN", value: [], options: ["VÍA SECA", "VÍA HÚMEDA"] },
        { label: "tipo_iluminacion", type: "multiselect", textLabel: "TIPO DE ILUMINACIÓN", value: [], options: ["NATURAL", "BLANCA ARTIFICIAL", "ULTRAVIOLETA"] },
        { label: "desmagnetizacion", type: "select", textLabel: "DESMAGNETIZACIÓN", value: "" },
        { label: "campo_residual_final", type: "text", textLabel: "CAMPO RESIDUAL FINAL", value: "" },
        { label: "temperatura_superficie", type: "text", textLabel: "TEMPERATURA DE SUPERFICIE", value: "" },
        { label: "concentracion_bano", type: "text", textLabel: "CONCENTRACIÓN DEL BAÑO", value: "" },
        
        // Otros campos
        { label: "detalle_pieza", type: "textLong", textLabel: "DETALLE DE LA PIEZA", value: "" },
        { label: "observaciones", type: "textLong", textLabel: "OBSERVACIONES", value: "" },
        { label: "resultado_final", type: "select", textLabel: "RESULTADO FINAL", value: "" }
    ],
});

// Campos principales (excluyendo tablas y secciones especiales)
const mainFields = computed(() => {
    const excludedLabels = [
        'limpiador_apl', 'limpiador_fabricante', 'limpiador_ref_comercial', 'limpiador_lote',
        'particulas_apl', 'particulas_fabricante', 'particulas_ref_comercial', 'particulas_lote',
        'pintura_apl', 'pintura_fabricante', 'pintura_ref_comercial', 'pintura_lote',
        'tipo_equipo', 'marca_equipo', 'modelo_equipo', 'cod_metrologico_equipo', 'fecha_calibracion_equipo',
        'tipo_magnetizacion', 'tipo_corriente', 'amperaje',
        'clase_particula', 'tipo_particulas', 'secuencia_aplicacion', 'modo_aplicacion', 'tipo_iluminacion',
        'desmagnetizacion', 'campo_residual_final', 'temperatura_superficie', 'concentracion_bano',
        'detalle_pieza', 'observaciones', 'resultado_final'
    ];
    
    return form.inputs.filter(i => i.type !== 'textLong' && !excludedLabels.includes(i.label));
});

function handleImageUpload(event) {
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
            detallePiezaImagen.value = e.target.result;
            const detallePiezaInput = form.inputs.find(i => i.label === 'detalle_pieza');
            if (detallePiezaInput) {
                detallePiezaInput.value = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    detallePiezaImagen.value = null;
    const detallePiezaInput = form.inputs.find(i => i.label === 'detalle_pieza');
    if (detallePiezaInput) {
        detallePiezaInput.value = '';
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

    // Agregar discontinuidades como JSON
    form.inputs.push({
        label: "discontinuidades",
        textLabel: "DISCONTINUIDADES",
        value: JSON.stringify(discontinuidades.value)
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
