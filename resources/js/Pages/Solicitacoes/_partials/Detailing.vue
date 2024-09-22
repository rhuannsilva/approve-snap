<script setup lang="ts">
import { ref, defineProps } from 'vue';

interface FileItem {
  base64: string;
  name_file: string;
}

const props = defineProps<{
  files: FileItem[];
}>();

</script>

<template>
  <div class="w-full p-4 grid grid-cols-1 gap-4">
    <div class="overflow-auto max-h-32 custom-scrollbar">
      <div v-for="(item, index) in props.files" :key="index" class="flex items-center gap-4 mb-2">
        <img class="w-14 h-14 object-cover rounded-md" :src="item.base64" alt="">
        <span>{{ item.name_file }}</span>
      </div>
    </div>
  </div>
</template>

<style scoped>

.custom-scrollbar::-webkit-scrollbar {
  width: 8px; /* Largura da barra de rolagem */
}

.custom-scrollbar::-webkit-scrollbar-track {
  background-color: #f1f1f1; /* Cor do fundo da barra de rolagem */
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: #888; /* Cor do polegar (parte que se move) */
  border-radius: 10px; /* Deixa o polegar com cantos arredondados */
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: #555; /* Cor do polegar ao passar o mouse */
}
</style>