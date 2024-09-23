<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#f8f8ff]">
        <div
            class="w-full sm:max-w-md mt-6 px-6 py-4 bg-[#f8f8ff] border-[#d0d7e7] border overflow-hidden sm:rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
