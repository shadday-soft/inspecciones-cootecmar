<script setup>
import { ScheduleXCalendar } from "@schedule-x/vue";
import { createEventsServicePlugin } from "@schedule-x/events-service";
import {
  createCalendar,
  createViewDay,
  createViewMonthGrid,
  createViewWeek,
  viewMonthGrid,
} from "@schedule-x/calendar";
import "@schedule-x/theme-shadcn/dist/index.css";
import Modal from "@/Components/Customs/Modal.vue";
import ItemDetail from "@/Pages/Inspections/ItemDetail.vue";
import Show from "@/Pages/Inspections/Show.vue";
import { ref } from "vue";

const visible = ref(false);
const eventSelected = ref(null);
const eventsServicePlugin = createEventsServicePlugin();

const calendarApp = createCalendar({
  theme: "shadcn",
  selectedDate: new Date().toISOString().split("T")[0],
  defaultView: viewMonthGrid.name,
  dayBoundaries: {
    start: "06:00",
    end: "19:00",
  },
  locale: "es-ES",
  views: [
    createViewDay(),
    createViewWeek(),
    createViewMonthGrid(),
    // createViewMonthAgenda(),
  ],
  callbacks: {
    onEventClick(calendarEvent) {
      eventSelected.value = inspections.value.find(
        (item) => item.id === calendarEvent.id
      );
      visible.value = true;
      console.log(calendarEvent);
    },
  },
  events: [],
  plugins: [eventsServicePlugin],
});
const inspections = ref([]);

const getInspection = () => {
  axios.get(route("inspections.index")).then((response) => {
    inspections.value = response.data;
    response.data.forEach((item) => {
      calendarApp.eventsService.add({
        title: item.code,
        start: item.fecha,
        description: item.descripcion,
        end: item.fecha,
        people: item.user,
        id: item.id,
      });
    });
  });
};
getInspection();
</script>

<template>
  <div class="p-4">
    <ScheduleXCalendar class="h-[50vh]" :calendar-app="calendarApp">
      <template #monthGridEvent="{ calendarEvent }">
        <div
          class="w-full text-white rounded-lg p-1 flex justify-between"
          :class="
            inspections.find((x) => x.id == calendarEvent.id).prioridad == 'Alta'
              ? 'bg-danger'
              : inspections.find((x) => x.id == calendarEvent.id).prioridad == 'Media'
              ? 'bg-warning'
              : 'bg-primary'
          "
        >
          <p>
            {{ calendarEvent.title }}
          </p>

          <p class="font-bold">
            {{ calendarEvent.people ? calendarEvent.people.name : "Sin Asignación" }}
          </p>
        </div>
      </template>
    </ScheduleXCalendar>
  </div>

  <Show v-if="eventSelected" v-model="visible" :inspeccion="eventSelected"></Show>
</template>
