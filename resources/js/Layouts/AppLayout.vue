<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";

import {
  Dialog,
  DialogPanel,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  Bars3BottomLeftIcon,
  CogIcon,
  HomeIcon,
  PhotoIcon,
  PlusIcon,
  RectangleStackIcon,
  Squares2X2Icon,
  UserGroupIcon,
  XMarkIcon,
} from "@heroicons/vue/24/outline";
import { MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import CreateRequets from "@/Components/CreateRequets.vue";

defineProps({
  title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
  router.put(
    route("current-team.update"),
    {
      team_id: team.id,
    },
    {
      preserveState: false,
    }
  );
};

const logout = () => {
  router.post(route("logout"));
};

const sidebarNavigation = [
  {
    name: "Inicio",
    href: "dashboard",
    icon: HomeIcon,
    current: route().current("dashboard"),
  },
  {
    name: "Equipos",
    href: "tools.index",
    icon: Squares2X2Icon,
    current: route().current("tools.*"),
  },
  {
    name: "Solicitud de Inspecciones",
    href: "inspections.index",
    icon: PhotoIcon,
    current: route().current("inspections.*"),
  },
  //{ name: "Personal", href: "dashboard", icon: UserGroupIcon, current: false },
  {
    name: "Mis tareas",
    href: "tasks.index",
    icon: RectangleStackIcon,
    current: route().current("tasks.*"),
  },
  { name: "Ajustes", href: "dashboard", icon: CogIcon, current: false },
];
const userNavigation = [
  { name: "Your Profile", action: () => console.log("Your Profile") },
  { name: "Sign out", action: logout },
];

const mobileMenuOpen = ref(false);
</script>

<template>
  <div>
    <Head :title="title" />

    <div class="flex h-screen">
      <!-- Narrow sidebar -->
      <div class="hidden w-28 overflow-y-auto bg-primary md:block">
        <div class="flex w-full flex-col items-center py-6">
          <div class="flex shrink-0 items-center">
            <img
              class="h-8 w-auto"
              src="https://tailwindui.com/plus/img/logos/mark.svg?color=white"
              alt="Your Company"
            />
          </div>
          <div class="mt-6 w-full flex-1 space-y-1 px-2">
            <Link
              v-for="item in sidebarNavigation"
              :key="item.name"
              :href="route(item.href)"
              :class="[
                item.current
                  ? 'bg-white text-primary shadow-sm shadow-white'
                  : 'text-indigo-100 hover:bg-indigo-800 hover:text-white',
                'group flex w-full flex-col items-center rounded-md p-3 text-xs font-medium',
              ]"
              :aria-current="item.current ? 'page' : undefined"
            >
              <component
                :is="item.icon"
                :class="[
                  item.current
                    ? 'text-primary'
                    : 'text-indigo-300 group-hover:text-white',
                  'size-6',
                ]"
                aria-hidden="true"
              />
              <span class="mt-2 text-center">{{ item.name }}</span>
            </Link>
          </div>
        </div>
      </div>

      <!-- Mobile menu -->
      <TransitionRoot as="template" :show="mobileMenuOpen">
        <Dialog class="relative z-20 md:hidden" @close="mobileMenuOpen = false">
          <TransitionChild
            as="template"
            enter="transition-opacity ease-linear duration-300"
            enter-from="opacity-0"
            enter-to="opacity-100"
            leave="transition-opacity ease-linear duration-300"
            leave-from="opacity-100"
            leave-to="opacity-0"
          >
            <div class="fixed inset-0 bg-gray-600/75" />
          </TransitionChild>

          <div class="fixed inset-0 z-40 flex">
            <TransitionChild
              as="template"
              enter="transition ease-in-out duration-300 transform"
              enter-from="-translate-x-full"
              enter-to="translate-x-0"
              leave="transition ease-in-out duration-300 transform"
              leave-from="translate-x-0"
              leave-to="-translate-x-full"
            >
              <DialogPanel
                class="relative flex w-full max-w-xs flex-1 flex-col bg-primary pb-4 pt-5"
              >
                <TransitionChild
                  as="template"
                  enter="ease-in-out duration-300"
                  enter-from="opacity-0"
                  enter-to="opacity-100"
                  leave="ease-in-out duration-300"
                  leave-from="opacity-100"
                  leave-to="opacity-0"
                >
                  <div class="absolute right-0 top-1 -mr-14 p-1">
                    <button
                      type="button"
                      class="flex size-12 items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-white"
                      @click="mobileMenuOpen = false"
                    >
                      <XMarkIcon class="size-6 text-white" aria-hidden="true" />
                      <span class="sr-only">Close sidebar</span>
                    </button>
                  </div>
                </TransitionChild>
                <div class="flex shrink-0 items-center px-4">
                  <img
                    class="h-8 w-auto"
                    src="https://tailwindui.com/plus/img/logos/mark.svg?color=white"
                    alt="Your Company"
                  />
                </div>
                <div class="mt-5 h-0 flex-1 overflow-y-auto px-2">
                  <nav class="flex h-full flex-col">
                    <div class="space-y-1">
                      <a
                        v-for="item in sidebarNavigation"
                        :key="item.name"
                        :href="item.href"
                        :class="[
                          item.current
                            ? 'bg-indigo-800 text-white'
                            : 'text-indigo-100 hover:bg-indigo-800 hover:text-white',
                          'group flex items-center rounded-md px-3 py-2 text-sm font-medium',
                        ]"
                        :aria-current="item.current ? 'page' : undefined"
                      >
                        <component
                          :is="item.icon"
                          :class="[
                            item.current
                              ? 'text-white'
                              : 'text-indigo-300 group-hover:text-white',
                            'mr-3 size-6',
                          ]"
                          aria-hidden="true"
                        />
                        <span>{{ item.name }}</span>
                      </a>
                    </div>
                  </nav>
                </div>
              </DialogPanel>
            </TransitionChild>
            <div class="w-14 shrink-0" aria-hidden="true">
              <!-- Dummy element to force sidebar to shrink to fit close icon -->
            </div>
          </div>
        </Dialog>
      </TransitionRoot>

      <!-- Content area -->
      <div class="flex flex-1 flex-col overflow-hidden">
        <header class="w-full">
          <div class="relative z-10 flex h-14 shrink-0 bg-white">
            <button
              type="button"
              class="border-r border-gray-200 px-4 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 md:hidden"
              @click="mobileMenuOpen = true"
            >
              <span class="sr-only">Open sidebar</span>
              <Bars3BottomLeftIcon class="size-6" aria-hidden="true" />
            </button>
            <div class="flex flex-1 justify-between px-4 sm:px-6 items-center">
              <div class="text-xl font-bold text-primary">{{ title }}</div>
              <div class="ml-2 flex items-center space-x-4 sm:ml-6 sm:space-x-6">
                <!-- Profile dropdown -->
                <Menu as="div" class="relative shrink-0">
                  <div>
                    <MenuButton
                      class="flex rounded-full bg-white text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                    >
                      <span class="sr-only">Open user menu</span>
                      <img
                        class="size-8 rounded-full"
                        :src="$page.props.auth.user.profile_photo_url"
                        alt=""
                      />
                    </MenuButton>
                  </div>
                  <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
                  >
                    <MenuItems
                      class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black/5 focus:outline-none"
                    >
                      <MenuItem
                        v-for="item in userNavigation"
                        :key="item.name"
                        v-slot="{ active }"
                      >
                        <div
                          @click="item.action"
                          :class="[
                            active ? 'bg-gray-100 outline-none' : '',
                            'block px-4 py-2 text-sm text-gray-700 cursor-pointer',
                          ]"
                        >
                          {{ item.name }}
                        </div>
                      </MenuItem>
                    </MenuItems>
                  </transition>
                </Menu>

                <button
                  type="button"
                  class="flex items-center justify-center rounded-full bg-indigo-600 p-1 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                  <PlusIcon class="size-6" aria-hidden="true" />
                  <span class="sr-only">Add file</span>
                </button>
              </div>
            </div>
          </div>
        </header>

        <!-- Main content -->
        <div class="flex flex-1 items-stretch overflow-hidden pb-4">
          <main class="flex-1 overflow-y-auto">
            <!-- Primary column -->
            <section
              aria-labelledby="primary-heading"
              class="flex h-full min-w-0 flex-1 flex-col lg:order-last"
            >
              <div class="py-4">
                <div class="sm:px-6 lg:px-8">
                  <div
                    class="bg-white overflow-hidden shadow-xl sm:rounded-lganimate-fadeinup animate-once"
                  >
                    <slot />
                  </div>
                </div>
              </div>
            </section>
          </main>
        </div>
      </div>
    </div>
  </div>
</template>
