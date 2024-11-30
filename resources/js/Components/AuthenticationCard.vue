<template>
    <div class="grid grid-cols-5">
        <div class=" col-span-3 hidden lg:block">
            <img class="min-h-screen object-cover" src="https://upload.wikimedia.org/wikipedia/commons/f/f0/Profesional_leyendo.jpg" alt="">
        </div>
        <div class=" col-span-full lg:col-span-2 min-h-screen flex flex-col justify-center items-center pt-6 sm:pt-0 bg-gray-50">
            <div>
                <slot name="logo" />
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>
    </div>
</template>
