<template>
  <Drawer
    v-model:visible="visible"
    :pt="{
      header: { class: 'bg-primary !h-12 !text-sm  -my-1' },
      title: { class: '!text-white !text-sm' },
    }"
    :header="inspeccion.code"
    position="right"
  >
    <div class="py-2 h-[91vh] overflow-y-auto">
      <div class="flex flex-col gap-y-2">
        <ItemDetail
          label="Codigo"
          :value="inspeccion.code"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.solicitante"
          label="Solicitante"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.fecha"
          label="Fecha Propuesta"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          v-if="inspeccion.fecha_programada"
          :value="inspeccion.fecha_programada"
          label="Programación"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.duracion + ' Horas'"
          label="Duracion"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.supervisor"
          label="Supervisor"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.descripcion"
          label="Descripción"
          class="flex justify-between"
        ></ItemDetail>
        <ItemDetail
          :value="inspeccion.prioridad"
          label="Prioridad"
          class="flex justify-between text-white"
          :class="
            inspeccion.prioridad == 'Alta'
              ? 'bg-danger'
              : inspeccion.prioridad == 'Media'
              ? 'bg-warning'
              : 'bg-primary'
          "
        >
        </ItemDetail>
      </div>

      <div class="space-y-2 my-2">
        <p class="text-md font-semibold">Tipos de Inspecciones</p>
        <div class="flex flex-col gap-y-2">
          <ul
            class="px-2 py-1 border-primary text-primary border rounded-md cursor-default"
            v-for="(type, index) in inspeccion.tipo.split(', ')"
          >
            {{
              index + 1
            }}.
            {{
              type
            }}
          </ul>
        </div>
      </div>
      <div v-if="inspeccion.user" class="flex flex-col gap-y-2">
        <div class="flex flex-col gap-x-4 w-full gap-y-2">
          <h2 class="text-md font-semibold">Equipos Asignados:</h2>
          <span
            class="border py-1 px-4 rounded-sm"
            v-for="(tool, index) in inspeccion.tools"
            :key="tool.id"
          >
            {{ tool.name }}
          </span>
        </div>
        <div class="flex flex-col justify-start text-md gap-y-4 w-full">
          <div
            class="flex gap-x-2 items-center pr-6 bg-primary text-white rounded-lg w-full"
          >
            <div>
              <img :src="inspeccion.user.profile_photo_url" class="" />
            </div>
            <span class="flex flex-col">
              <h3 class="font-bold">Inspector</h3>
              <p>{{ inspeccion.user.name }}</p>
            </span>
          </div>
          <div
            v-if="inspeccion.ayudante"
            class="flex gap-x-2 items-center w-full pr-6 bg-primary text-white rounded-lg"
          >
            <div>
              <img :src="inspeccion.ayudante.profile_photo_url" class="" />
            </div>
            <span class="flex flex-col">
              <h3 class="font-bold">Ayudante</h3>
              <p>{{ inspeccion.ayudante.name }}</p>
            </span>
          </div>
        </div>
      </div>

      <div v-else>
        <p class="p-2 bg-danger text-white text-center font-bold rounded-md">
          Sin Asignación
        </p>
      </div>
    </div>
    <!-- <Modal v-model="visible" title="Inspección" close-on-escape>
      <div class="p-2 flex flex-col gap-y-2">
       
        <div>
          <p class="text-md font-semibold">Tipos de Inspecciones</p>
          <div class="grid grid-cols-6 gap-2">
            <ul
              class="px-2 py-1 border-primary text-primary border rounded-md cursor-default"
              v-for="type in eventSelected.tipo.split(', ')"
            >
              {{
                type
              }}
            </ul>
          </div>
        </div>

        <div v-if="eventSelected.user" class="flex flex-col gap-y-2">
          <div class="flex gap-x-4 w-full items-center">
            <h2 class="text-md font-semibold">Equipos Asignados:</h2>
            <span
              class="border py-1 px-4 rounded-sm"
              v-for="tool in eventSelected.tools"
              :key="tool.id"
            >
              {{ tool.name }}
            </span>
          </div>
          <div class="flex justify-start text-md gap-x-4">
            <div
              class="flex gap-x-2 items-center pr-6 bg-primary text-white rounded-r-lg"
            >
              <div>
                <img :src="eventSelected.user.profile_photo_url" class="" />
              </div>
              <span class="flex flex-col">
                <h3 class="font-bold">Inspector</h3>
                <p>{{ eventSelected.user.name }}</p>
              </span>
            </div>
            <div
              v-if="eventSelected.ayudante"
              class="flex gap-x-2 items-center pr-6 bg-primary text-white rounded-r-lg"
            >
              <div>
                <img :src="eventSelected.ayudante.profile_photo_url" class="" />
              </div>
              <span class="flex flex-col">
                <h3 class="font-bold">Ayudante</h3>
                <p>{{ eventSelected.ayudante.name }}</p>
              </span>
            </div>
          </div>
        </div>

        <div v-else>
          <p class="p-2 bg-danger text-white text-center font-bold rounded-md">
            Sin Asignación
          </p>
        </div>
      </div>

      <template #footer>
        <div class="flex gap-x-2">
          <Button
            class="!h-8"
            label="Cancelar"
            severity="danger"
            icon="fa-solid fa-xmark"
            @click="visible = false"
          />
          <Button
            class="!h-8"
            label="Guardar"
            severity="success"
            icon="fa-solid fa-save"
            @click="save()"
          />
        </div>
      </template> 
    </Modal> -->
  </Drawer>
</template>
<script setup>
import ItemDetail from "@/Pages/Inspections/ItemDetail.vue";

const props = defineProps({
  inspeccion: Object,
});
const visible = defineModel();
</script>
